<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Notification;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceipt;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    // User: Show booking form
    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

    // User: Check availability (AJAX)
    public function checkAvailability(Request $request, Service $service)
    {
        $date = $request->query('date');
        if (!$date) return response()->json(['available' => false]);
        
        $isAvailable = $service->isAvailableOn($date);
        
        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Date is available.' : 'This date is unavailable.'
        ]);
    }

    // User: Get all unavailable dates (AJAX for Calendar)
    public function getUnavailableDates(Service $service)
    {
        // 1. Get explicitly blocked dates
        $blockedDates = $service->availability()
            ->whereDate('unavailable_date', '>=', now())
            ->pluck('unavailable_date')
            ->toArray();

        // 2. Get fully booked dates
        // For simplicity, we assume 1 booking blocks the day. 
        // If multiple bookings per day are allowed, this logic needs refinement (checking against capacity).
        // For now, based on "double-booking prevent", 1 booking = blocked.
        $bookedDates = $service->bookings()
            ->whereDate('booking_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_date')
            ->map(function ($date) {
                return $date->format('Y-m-d');
            })
            ->toArray();

        // Merge and unique
        $allUnavailable = array_values(array_unique(array_merge($blockedDates, $bookedDates)));

        return response()->json($allUnavailable);
    }

    // User: Store booking
    public function store(Request $request, Service $service)
    {
        // 1. Availability Check (Optimistic first check)
        if (!$service->isAvailableOn($request->booking_date)) {
            return back()->with('error', 'The selected date is no longer available. Please choose another date.');
        }

        // 2. Standard Ecommerce Validation
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'guest_count' => 'required|integer|min:1', // Mapping guest_count to Quantity
            'booking_date' => 'nullable|date',
            'package_name' => 'nullable|string|max:100',
            'selected_addons' => 'nullable|array',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
        ];

        $request->validate($rules);

        // 3. Price Calculation (Quantity * Price)
        $quantity = max(1, (int) $request->guest_count);
        $basePrice = $service->getCurrentPrice();
        
        if ($request->package_name) {
            $basePrice = $service->getTieredPrice($request->package_name) ?? $service->getCurrentPrice();
        }

        $finalPrice = $basePrice * $quantity;

        if ($request->selected_addons) {
            foreach ($request->selected_addons as $addonName) {
                $finalPrice += ($service->getAddOnPrice($addonName) * $quantity);
            }
        }

        // Apply Coupon
        $discount = 0;
        $appliedCoupon = null;
        if ($request->coupon_code) {
            $appliedCoupon = Coupon::where('code', $request->coupon_code)->first();
            if ($appliedCoupon && $appliedCoupon->isValidFor($finalPrice, $service->user_id)) {
                $discount = $appliedCoupon->calculateDiscount($finalPrice);
                $finalPrice -= $discount;
            }
        }

        // Set Default Date for Products
        $bookingDate = $request->booking_date ?? now()->addDay();
        $categorySlug = $service->category->slug ?? null;

        // Initialize booking_data
        $bookingData = $request->input('booking_data', []);
        $bookingData['package_name'] = $request->package_name;
        $bookingData['selected_addons'] = $request->selected_addons ?? [];
        if ($appliedCoupon) {
            $bookingData['coupon_code'] = $appliedCoupon->code;
            $bookingData['discount_amount'] = $discount;
        }

        try {
            $booking = DB::transaction(function () use ($request, $service, $bookingData, $finalPrice, $appliedCoupon, $bookingDate, $categorySlug) {
                // Re-fetch service with lock to prevent race conditions
                $lockedService = Service::lockForUpdate()->find($service->id);
                
                // Double-check availability if needed, otherwise skip for products
                if ($lockedService->price_type === 'event' && !$lockedService->isAvailableOn($bookingDate)) {
                    throw new \Exception('Slot taken just now. Please try another date.');
                }

                // 5. Calculate Commission (10%)
                $commissionRate = 0.10;
                $commissionFee = $finalPrice * $commissionRate;
                $vendorNet = $finalPrice - $commissionFee;

                // 6. Create Booking Record
                $booking = Booking::create([
                    'user_id' => Auth::id(), // Will be null for guests
                    'service_id' => $service->id,
                    'vendor_id' => $service->user_id,
                    'booking_date' => $bookingDate,
                    'status' => 'pending', 
                    'notes' => $request->notes,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_email' => $request->customer_email,
                    'event_type' => $request->event_type ?? 'product_sale',
                    'event_location' => $request->event_location ?? 'Online Order',
                    'event_address' => $request->event_location ?? 'Online Order',
                    'guest_count' => $request->guest_count, // Generic mapping
                    'budget' => $request->budget,
                    'special_requests' => $request->special_requests,
                    'booking_data' => $bookingData,
                    'total_price' => $finalPrice,
                    'commission_fee' => $commissionFee,
                    'vendor_net_amount' => $vendorNet,
                    'payout_status' => 'pending',
                ]);

                // Increment coupon usage if valid
                if ($appliedCoupon) {
                    $appliedCoupon->increment('used_count');
                }

                // Service desk assignment
                $deskCategories = [
                    'catering' => 'catering',
                    'photography' => 'photography',
                    'videography' => 'videography',
                    'drone' => 'drone',
                    'live_streaming' => 'live_streaming',
                ];
                
                if ($categorySlug && isset($deskCategories[$categorySlug])) {
                     $this->assignToDesk($booking, $deskCategories[$categorySlug]);
                }
                
                return $booking;
            });

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        // Notify the vendor about new booking with details
        $countLabel = in_array($categorySlug, ['catering', 'wedding-catering', 'corporate-lunch']) ? 'plates' : 'guests';
        $specializedInfo = '';
        if ($categorySlug === 'transport') {
            $specializedInfo = ' (' . ($booking->booking_data['passengers'] ?? 0) . ' passengers, ' . ($booking->booking_data['pickup_location'] ?? 'N/A') . ' to ' . ($booking->booking_data['dropoff_location'] ?? 'N/A') . ')';
        } elseif ($categorySlug === 'visa') {
            $specializedInfo = ' (Nationality: ' . ($booking->booking_data['nationality'] ?? 'N/A') . ')';
        } elseif ($categorySlug === 'umrah' || $categorySlug === 'travel') {
            $specializedInfo = ' (' . ($booking->guest_count ?? 0) . ' travelers, ' . ($booking->booking_data['duration_days'] ?? 0) . ' days)';
        }

        Notification::createOrderNotification(
            $service->user_id,
            'New Order Received!',
            'An elite order has been placed by ' . $request->customer_name . ' for "' . $service->name . '". Quantity: ' . $quantity . '. Status: Awaiting Verification.',
            route('vendor.orders'),
            'fa-shopping-cart',
            'indigo'
        );

        // Notify the user about their order (Only if logged in)
        if (Auth::check()) {
            Notification::createOrderNotification(
                Auth::id(),
                'Order Processed',
                'Your order for "' . $service->name . '" has been submitted for quality verification. Current Status: [Awaiting Store Approval].',
                route('bookings.index'),
                'fa-clock',
                'primary'
            );
        }

        // Send Email Receipt
        try {
            Mail::to($request->customer_email)->send(new BookingReceipt($booking));
        } catch (\Exception $e) {
            // Log mail error but don't stop flow
            \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Thank you! Your order has been placed successfully. Our fulfillment team will verify it shortly.');
    }

    /**
     * Assign booking to service desk and create ServiceDeskRequest
     */
    public function assignToDesk(Booking $booking, string $deskType)
    {
        $serviceDeskController = app(\App\Http\Controllers\ServiceDeskController::class);
        $deskRequest = $serviceDeskController->store(new Request([
            'customer_name' => $booking->customer_name,
            'customer_email' => $booking->customer_email,
            'customer_phone' => $booking->customer_phone,
            'service_type' => $booking->event_type,
            'desk_type' => $deskType,
            'priority' => 'medium',
            'booking_id' => $booking->id,
            'event_location' => $booking->event_location,
            'event_address' => $booking->event_address,
            'event_date' => $booking->booking_date,
            'guest_count' => $booking->guest_count,
        ]));

        // Handle JSON response correctly
        if (method_exists($deskRequest, 'getData')) {
            $data = $deskRequest->getData();
            return $data->reference ?? null;
        }

        return null;
    }

    // User: My Bookings
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $bookings = $user->bookings()->with(['service', 'review'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    // Vendor: Manage Orders
    public function vendorIndex()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $bookings = $user->receivedBookings()->with(['user', 'service'])->latest()->get();
        return view('vendor.orders', compact('bookings'));
    }

    // Vendor: Update Status
    public function updateStatus(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->vendor_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $oldStatus = $booking->status;

        DB::transaction(function () use ($request, $booking, $oldStatus) {
            $booking->update(['status' => $request->status]);

            // Handle Wallet logic: If moved to completed, add net amount to vendor balance
            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                $vendor = $booking->vendor;
                $vendor->increment('balance', $booking->vendor_net_amount);
            }
        });

        // Send Order Confirmation Mail on status confirmation
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            $recipientEmail = $booking->customer_email ?? $booking->user->email ?? null;
            if ($recipientEmail) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\OrderConfirmationMail($booking));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Order Confirmation Mail failed: ' . $e->getMessage());
                }
            }
        }

        // Notify the customer about status change
        $statusMessages = [
            'confirmed' => 'Elite news! Your order has been verified and confirmed by the store.',
            'completed' => 'Your order has been delivered successfully. We hope you enjoy your premium purchase!',
            'cancelled' => 'Update: Your order has been cancelled by the store.',
        ];

        $colors = [
            'confirmed' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
        ];

        $icons = [
            'confirmed' => 'fa-calendar-check',
            'completed' => 'fa-check-double',
            'cancelled' => 'fa-circle-xmark',
        ];

        Notification::createOrderNotification(
            $booking->user_id,
            'Order Update: ' . ucfirst($request->status),
            'The store for [' . $booking->service->name . '] has updated your order status to: ' . strtoupper($request->status) . '.',
            route('bookings.index'),
            $icons[$request->status],
            $colors[$request->status]
        );

        // Notify vendor about their own action
        Notification::createOrderNotification(
            Auth::id(),
            'Order Record Updated',
            'You have ' . $request->status . ' the order for ' . $booking->customer_name . '.',
            Auth::user()->role === 'admin' ? route('admin.bookings') : route('vendor.orders'),
            'fa-check-circle',
            'blue'
        );

        return redirect()->back()->with('success', 'Retail record synchronized. Order status updated.');
    }

    public function downloadInvoice(Booking $booking)
    {
        // Authorization: User/Vendor/Admin can download
        if (Auth::id() !== $booking->user_id && Auth::id() !== $booking->vendor_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $booking->load(['service', 'vendor', 'user']);
        
        $pdf = Pdf::loadView('admin.booking-invoice', compact('booking'));
        
        return $pdf->download('Invoice-' . $booking->id . '.pdf');
    }
}
