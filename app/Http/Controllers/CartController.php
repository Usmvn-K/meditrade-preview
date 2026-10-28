<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Refresh prices from DB to ensure they reflect current values and sale status
        foreach($cart as $id => &$details) {
            $service = Service::find($id);
            if($service) {
                $details['price'] = ($service->is_on_sale && $service->sale_price) ? $service->sale_price : $service->price;
                $details['original_price'] = $service->price;
                $details['is_on_sale'] = $service->is_on_sale && $service->sale_price && $service->sale_price < $service->price;
            }
        }
        session()->put('cart', $cart);

        return view('cart.index', compact('cart'));
    }

    public function getCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Refresh prices and images from DB
        foreach($cart as $id => &$details) {
            $service = Service::find($id);
            if($service) {
                $details['id'] = $service->id;
                $details['price'] = ($service->is_on_sale && $service->sale_price) ? (float)$service->sale_price : (float)$service->price;
                $details['original_price'] = (float)$service->price;
                $details['is_on_sale'] = $service->is_on_sale && $service->sale_price && $service->sale_price < $service->price;
                if (empty($details['image'])) {
                    $details['image'] = $service->getFeaturedImageUrl();
                }
            }
        }
        session()->put('cart', $cart);

        return response()->json($this->formatCartResponse($cart));
    }

    public function addToCart(Request $request, Service $service)
    {
        $cart = session()->get('cart', []);
        $qty = max(1, (int)$request->input('quantity', 1));

        if(isset($cart[$service->id])) {
            $cart[$service->id]['quantity'] += $qty;
        } else {
            $price = ($service->is_on_sale && $service->sale_price) ? (float)$service->sale_price : (float)$service->price;
            $cart[$service->id] = [
                "id" => $service->id,
                "name" => $service->name,
                "quantity" => $qty,
                "price" => $price,
                "original_price" => (float)$service->price,
                "is_on_sale" => $service->is_on_sale && $service->sale_price && $service->sale_price < $service->price,
                "image" => $service->getFeaturedImageUrl(),
                "vendor" => 'Habibi Herbal'
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($this->formatCartResponse($cart, 'Product added to cart successfully!'));
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function buyNow(Request $request, Service $service)
    {
        $cart = session()->get('cart', []);
        $price = ($service->is_on_sale && $service->sale_price) ? (float)$service->sale_price : (float)$service->price;

        $cart[$service->id] = [
            "id" => $service->id,
            "name" => $service->name,
            "quantity" => 1,
            "price" => $price,
            "original_price" => (float)$service->price,
            "is_on_sale" => $service->is_on_sale && $service->sale_price && $service->sale_price < $service->price,
            "image" => $service->getFeaturedImageUrl(),
            "vendor" => 'Habibi Herbal'
        ];

        session()->put('cart', $cart);
        return redirect()->route('cart.checkout');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $qty = (int)$request->input('quantity', 1);

        if($id) {
            $cart = session()->get('cart', []);
            if(isset($cart[$id])) {
                if ($qty <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]["quantity"] = $qty;
                }
                session()->put('cart', $cart);
                session()->flash('success', 'Cart updated successfully');
            }

            if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json($this->formatCartResponse($cart, 'Cart updated successfully'));
            }

            return redirect()->back();
        }

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => false, 'message' => 'Invalid product ID'], 400);
        }
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $id = $request->input('id');
        if($id) {
            $cart = session()->get('cart', []);
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                session()->flash('success', 'Product removed successfully');
            }

            if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json($this->formatCartResponse($cart, 'Product removed successfully'));
            }

            return redirect()->back();
        }

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => false, 'message' => 'Invalid product ID'], 400);
        }
        return redirect()->back();
    }

    protected function formatCartResponse($cart, $message = null)
    {
        $items = [];
        $subtotal = 0;
        $totalQuantity = 0;

        foreach ($cart as $id => $item) {
            $price = (float)($item['price'] ?? 0);
            $qty = (int)($item['quantity'] ?? 1);
            $itemSubtotal = $price * $qty;
            $subtotal += $itemSubtotal;
            $totalQuantity += $qty;

            $items[] = [
                'id' => (int)($item['id'] ?? $id),
                'name' => $item['name'] ?? 'Product',
                'price' => $price,
                'formattedPrice' => 'Rs. ' . number_format($price, 0),
                'original_price' => isset($item['original_price']) ? (float)$item['original_price'] : $price,
                'formattedOriginalPrice' => isset($item['original_price']) ? 'Rs. ' . number_format((float)$item['original_price'], 0) : null,
                'is_on_sale' => !empty($item['is_on_sale']),
                'quantity' => $qty,
                'image' => !empty($item['image']) ? $item['image'] : asset('images/placeholder.jpg'),
                'subtotal' => $itemSubtotal,
                'formattedSubtotal' => 'Rs. ' . number_format($itemSubtotal, 0),
            ];
        }

        return [
            'success' => true,
            'message' => $message,
            'cart' => $items,
            'cartCount' => count($items),
            'totalQuantity' => $totalQuantity,
            'subtotal' => $subtotal,
            'formattedSubtotal' => 'Rs. ' . number_format($subtotal, 0),
        ];
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Refresh prices
        $total = 0;
        $savings = 0;
        foreach($cart as $id => &$details) {
            $service = Service::find($id);
            if($service) {
                $details['price'] = ($service->is_on_sale && $service->sale_price) ? $service->sale_price : $service->price;
                $details['original_price'] = $service->price;
                $details['is_on_sale'] = $service->is_on_sale && $service->sale_price && $service->sale_price < $service->price;
            }
            $total += $details['price'] * $details['quantity'];
            if(!empty($details['is_on_sale'])) {
                $savings += ($details['original_price'] - $details['price']) * $details['quantity'];
            }
        }
        session()->put('cart', $cart);

        return view('cart.checkout', compact('cart', 'total', 'savings'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $bookings = [];
        foreach($cart as $id => $details) {
            $service = Service::find($id);
            if(!$service) continue;

            $quantity = (int) $details['quantity'];
            $price = ($service->is_on_sale && $service->sale_price) ? (float)$service->sale_price : (float)$service->price;
            $totalPrice = $price * $quantity;

            // Direct single-brand store: 0 commission, 100% net
            $commissionFee = 0.00;
            $vendorNet = $totalPrice;

            $booking = Booking::create([
                'user_id' => Auth::id(), // null for guest checkout
                'service_id' => $service->id,
                'vendor_id' => $service->user_id ?? 1,
                'booking_date' => now(),
                'status' => 'pending',
                'notes' => $request->notes,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'event_type' => 'product_sale',
                'event_location' => $request->shipping_address,
                'event_address' => $request->shipping_address,
                'guest_count' => $quantity,
                'total_price' => $totalPrice,
                'commission_fee' => $commissionFee,
                'vendor_net_amount' => $vendorNet,
                'payout_status' => 'pending',
                'booking_data' => [
                    'cart_order' => true,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                ],
            ]);

            $bookings[] = $booking;

            // Notify Admin
            try {
                Notification::createOrderNotification(
                    1, // Admin ID
                    'New Order Received!',
                    'Order placed by ' . $request->customer_name . ' for "' . $service->name . '". Qty: ' . $quantity . '. Total: Rs. ' . number_format($totalPrice),
                    route('admin.bookings'),
                    'fa-shopping-cart',
                    'indigo'
                );
            } catch (\Exception $e) {
                Log::warning('Admin notification could not be created: ' . $e->getMessage());
            }
        }

        // Notify customer if logged in
        if (Auth::check()) {
            try {
                Notification::createOrderNotification(
                    Auth::id(),
                    'Order Placed Successfully',
                    'Your order with ' . count($bookings) . ' item(s) has been submitted.',
                    route('bookings.index'),
                    'fa-clock',
                    'primary'
                );
            } catch (\Exception $e) {
                Log::warning('User notification could not be created: ' . $e->getMessage());
            }
        }

        // Optional email receipt
        if(!empty($bookings) && class_exists('\App\Mail\BookingReceipt')) {
            try {
                Mail::to($request->customer_email)->send(new \App\Mail\BookingReceipt($bookings[0]));
            } catch (\Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Thank you! Your order has been placed successfully. We will contact you soon for confirmation!');
    }
}