<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Global Query Setup
        $query = Service::query()->with(['user', 'category']);

        // Check if any filtering is active
        $isSearching = $request->filled('category') || $request->filled('search') || 
                      $request->filled('vendor_name') || $request->filled('city') || 
                      $request->filled('event_type') || $request->filled('date') || 
                      $request->filled('dates') || $request->filled('guests');

        // Apply Filters
        if ($request->filled('category')) {
            $slug = $request->get('category');
            $category = \App\Models\ServiceCategory::where('slug', $slug)->first();
            if ($category) {
                $catIds = $category->children()->pluck('id')->push($category->id);
                $query->whereIn('category_id', $catIds);
            }
        }

        if ($request->filled('city')) {
            $city = trim(str_replace([' Hub', ' District', ' Node', ' Core', ' Grid', ' Prime', ' Atoll', ' Marina'], '', $request->city));
            $query->where('location', 'like', "%" . $city . "%");
        }

        if ($request->filled('event_type')) {
            $type = $request->event_type;
            $query->where(function($q) use ($type) {
                $q->whereJsonContains('extra_data->event_types', $type)
                  ->orWhereJsonContains('extra_data->event_types', ucfirst(strtolower($type)))
                  ->orWhereJsonContains('extra_data->event_types', strtolower($type))
                  ->orWhereJsonContains('extra_data->event_types', strtoupper($type))
                  ->orWhere('description', 'like', "%$type%")
                  ->orWhere('name', 'like', "%$type%");
            });
        }

        if ($request->filled('guests')) {
            $query->where(function($q) use ($request) {
                $q->where('extra_data->capacity', '>=', (int)$request->guests)
                  ->orWhereNull('extra_data->capacity');
            });
        }

        // Date filter (Availability)
        $singleDate = $request->input('date');
        $checkin = null;
        $checkout = null;

        if ($request->filled('dates')) {
            $range = explode(' to ', $request->input('dates'));
            $checkin = $range[0] ?? null;
            $checkout = $range[1] ?? null;
            if (!$checkout) $singleDate = $checkin;
        }

        if ($checkin && $checkout) {
            $query->whereDoesntHave('bookings', function($q) use ($checkin, $checkout) {
                $q->where(function($sq) use ($checkin, $checkout) {
                    $sq->whereBetween('booking_date', [$checkin, $checkout])
                       ->orWhereBetween('event_end_date', [$checkin, $checkout]);
                })->whereIn('status', ['pending', 'confirmed']);
            });
        } elseif ($singleDate) {
            $query->whereDoesntHave('bookings', function($q) use ($singleDate) {
                $q->whereDate('booking_date', $singleDate)
                  ->whereIn('status', ['pending', 'confirmed']);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Only show featured by default, but if searching show all matching
        if (!$isSearching) {
            $query->where('is_featured', true);
        }

        $allServices = $query->latest()->get();
        
        $pakistanServices = $allServices->filter(function($service) {
            return str_contains(strtolower($service->location ?? ''), 'pakistan');
        });
        
        if (!$isSearching) $pakistanServices = $pakistanServices->take(12);
        
        $globalServices = $allServices->filter(function($service) {
            return !str_contains(strtolower($service->location ?? ''), 'pakistan');
        });
        
        if (!$isSearching) $globalServices = $globalServices->take(12);

        $categories = \App\Models\ServiceCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->where('name', 'not like', '%ELECTRONIC%')
            ->where('name', 'not like', '%FASHION%')
            ->where('name', 'not like', '%TECH%')
            ->where('name', 'not like', '%CLOTH%')
            ->where('name', 'not like', '%KUCH%')
            ->with('children')
            ->orderBy('sort_order')
            ->take(8)
            ->get();
        
        $cities = \App\Models\City::orderBy('name')->get();
        
        $customPackages = auth()->check() 
            ? \App\Models\CustomPackage::where('user_id', auth()->id())->with('services')->latest()->take(3)->get()
            : collect();
        
        // Real stats from database
        $stats = [
            'vendors' => User::where('role', 'vendor')->where('is_verified', true)->count(),
            'services' => Service::count(),
            'bookings' => Booking::where('status', 'completed')->count(),
            'users' => User::where('role', 'user')->count(),
        ];

        // Hardcoded UI Features
        $featureCards = json_decode(json_encode([
            [
                'title' => 'Browse Collections',
                'description' => 'Explore premium products with transparent pricing and authentic reviews.',
                'icon' => 'fa-solid fa-magnifying-glass',
                'delay' => 100,
                'style_blur' => 'bg-blue-500/20',
                'style_bg' => 'from-blue-500 to-indigo-500',
                'style_shadow' => 'shadow-blue-500/50',
                'style_text' => 'group-hover:text-blue-400'
            ],
            [
                'title' => 'Secure Checkout',
                'description' => 'Global payment options with escrow-secured protection.',
                'icon' => 'fa-solid fa-shield-check',
                'delay' => 200,
                'style_blur' => 'bg-red-500/20',
                'style_bg' => 'from-red-500 to-rose-500',
                'style_shadow' => 'shadow-red-500/50',
                'style_text' => 'group-hover:text-red-400'
            ],
            [
                'title' => 'Global Delivery',
                'description' => 'Door-to-door shipping across 150+ countries with real-time tracking.',
                'icon' => 'fa-solid fa-truck-fast',
                'delay' => 300,
                'style_blur' => 'bg-blue-600/20',
                'style_bg' => 'from-blue-600 to-blue-400',
                'style_shadow' => 'shadow-blue-600/50',
                'style_text' => 'group-hover:text-blue-400'
            ]
        ]));

        $testimonialSlides = [
            [
                'stars' => 5,
                'quote' => 'Exceptional quality and authentic luxury. The delivery was remarkably fast.',
                'name' => 'Sarah Ahmed',
                'role' => 'Premium Customer',
                'initial' => 'S',
                'color' => 'bg-blue-100 text-blue-600'
            ],
            [
                'stars' => 5,
                'quote' => 'The wholesale experience is unparalleled. Perfect for corporate gifting.',
                'name' => 'Ali Khan',
                'role' => 'Corporate Partner',
                'initial' => 'A',
                'color' => 'bg-red-100 text-red-600'
            ],
            [
                'stars' => 5,
                'quote' => 'Verified products and excellent support. Best shopping experience in Pakistan.',
                'name' => 'Fatima Hassan',
                'role' => 'Loyal Customer',
                'initial' => 'F',
                'color' => 'bg-blue-100 text-blue-600'
            ],
            [
                'stars' => 5,
                'quote' => 'Secure payments and global tracking gave me peace of mind. Highly recommended!',
                'name' => 'Bilal Sheikh',
                'role' => 'International Buyer',
                'initial' => 'B',
                'color' => 'bg-blue-100 text-blue-600'
            ]
        ];
        
        if ($request->header('X-Partial') === 'stats') {
            return view('partials.home-stats', compact('stats'));
        }
        
        if ($request->ajax()) {
            return view('partials.home-marketplace', compact('pakistanServices', 'globalServices', 'isSearching'));
        }

        return view('welcome', compact('pakistanServices', 'globalServices', 'stats', 'categories', 'featureCards', 'testimonialSlides', 'customPackages', 'cities', 'isSearching'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) return response()->json([]);

        $services = Service::where('name', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%")
            ->with('category')
            ->limit(5)
            ->get()
            ->map(function($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'category' => $s->category->name ?? 'Product',
                    'image' => $s->getFeaturedImage() ? (Str::startsWith($s->getFeaturedImage(), ['http', 'https']) ? $s->getFeaturedImage() : asset('storage/' . $s->getFeaturedImage())) : asset('images/placeholder.jpg'),
                    'url' => route('services.show', $s)
                ];
            });

        return response()->json($services);
    }
}
