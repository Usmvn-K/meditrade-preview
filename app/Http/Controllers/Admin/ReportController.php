<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function chartOfAccounts()
    {
        // 1. Consolidated Ledger Calculations (E-Commerce)
        $completedSales = Booking::where('status', 'completed')->sum('total_price');
        $confirmedSales = Booking::where('status', 'confirmed')->sum('total_price');
        
        // Assets
        $cashBankBalance = $completedSales + $confirmedSales;
        $inventoryAsset = ($completedSales + $confirmedSales) * 0.40;

        // Liabilities
        $salesTaxPayable = ($completedSales + $confirmedSales) * 0.05;
        $unearnedRevenue = Booking::where('status', 'pending')->sum('total_price');

        // Income
        $salesRevenue = $completedSales;

        // Expenses
        $cogs = $completedSales * 0.60;
        $gatewayFees = $completedSales * 0.03;
        $shippingExpenses = $completedSales * 0.05;

        $consolidatedTree = $this->formatAccountsForChart(
            $cashBankBalance,
            $inventoryAsset,
            $salesTaxPayable,
            $unearnedRevenue,
            $salesRevenue,
            $cogs,
            $gatewayFees,
            $shippingExpenses
        );

        // Fetch bookings for order-based analysis
        $bookings = Booking::with(['user', 'service.category'])->orderBy('created_at', 'desc')->get();

        // 2. Group by Product Category (formerly Event Type)
        $eventTypeReports = [];
        $bookingsByCategory = $bookings->groupBy(function($b) {
            return $b->service && $b->service->category ? $b->service->category->name : 'Uncategorized';
        });

        foreach ($bookingsByCategory as $catName => $group) {
            $catCompleted = $group->filter(fn($b) => $b->status === 'completed')->sum('total_price');
            $catConfirmed = $group->filter(fn($b) => $b->status === 'confirmed')->sum('total_price');
            
            $cCash = $catCompleted + $catConfirmed;
            $cInventory = $cCash * 0.40;
            $cSalesTax = $cCash * 0.05;
            $cUnearned = $group->filter(fn($b) => $b->status === 'pending')->sum('total_price');
            $cRevenue = $catCompleted;
            
            $cCogs = $catCompleted * 0.60;
            $cGateway = $catCompleted * 0.03;
            $cShipping = $catCompleted * 0.05;

            $tree = $this->formatAccountsForChart(
                $cCash,
                $cInventory,
                $cSalesTax,
                $cUnearned,
                $cRevenue,
                $cCogs,
                $cGateway,
                $cShipping
            );

            // Summary metrics
            $totalSales = $group->sum('total_price');
            $totalOrders = $group->count();
            $netProfit = $cRevenue - ($cCogs + $cGateway + $cShipping);
            $margin = $cRevenue > 0 ? ($netProfit / $cRevenue) * 100 : 0;

            $eventTypeReports[] = [
                'id' => strtolower(str_replace(' ', '_', $catName)),
                'name' => $catName,
                'bookings_count' => $totalOrders,
                'total_sales' => $totalSales,
                'net_profit' => $netProfit,
                'margin' => $margin,
                'accounts' => $tree
            ];
        }

        // 3. Individual Orders (formerly Projects)
        $projectReports = [];
        foreach ($bookings as $booking) {
            $orderName = "Order #" . $booking->id . " - " . ($booking->customer_name ?: ($booking->user ? $booking->user->name : 'Guest'));
            $productName = $booking->service ? $booking->service->name : 'Custom Package';
            $status = $booking->status;

            $bCompleted = $status === 'completed' ? $booking->total_price : 0;
            $bConfirmed = $status === 'confirmed' ? $booking->total_price : 0;

            $bCash = $bCompleted + $bConfirmed;
            $bInventory = $bCash * 0.40;
            $bSalesTax = $bCash * 0.05;
            $bUnearned = $status === 'pending' ? $booking->total_price : 0;
            $bRevenue = $bCompleted;

            $bCogs = $bCompleted * 0.60;
            $bGateway = $bCompleted * 0.03;
            $bShipping = $bCompleted * 0.05;

            $tree = $this->formatAccountsForChart(
                $bCash,
                $bInventory,
                $bSalesTax,
                $bUnearned,
                $bRevenue,
                $bCogs,
                $bGateway,
                $bShipping
            );

            $netProfit = $bRevenue - ($bCogs + $bGateway + $bShipping);
            $margin = $bRevenue > 0 ? ($netProfit / $bRevenue) * 100 : 0;

            $projectReports[] = [
                'id' => $booking->id,
                'name' => $orderName,
                'customer' => $booking->customer_name ?: ($booking->user ? $booking->user->name : 'Guest'),
                'service' => $productName,
                'event_type' => $booking->service && $booking->service->category ? $booking->service->category->name : 'Uncategorized',
                'booking_date' => $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'N/A',
                'status' => ucwords($status),
                'total_price' => $booking->total_price,
                'net_profit' => $netProfit,
                'margin' => $margin,
                'accounts' => $tree
            ];
        }

        return view('admin.reports.chart-of-accounts', [
            'accounts' => $consolidatedTree,
            'eventTypeReports' => $eventTypeReports,
            'projectReports' => $projectReports
        ]);
    }

    private function formatAccountsForChart($cash, $inventory, $salesTax, $unearned, $salesRevenue, $cogs, $gateway, $shipping)
    {
        return [
            'assets' => [
                'name' => 'Assets',
                'balance' => $cash + $inventory,
                'children' => [
                    ['name' => 'Cash/Bank Balance', 'balance' => $cash],
                    ['name' => 'Inventory Asset (Est.)', 'balance' => $inventory],
                ],
            ],
            'liabilities' => [
                'name' => 'Liabilities',
                'balance' => $salesTax + $unearned,
                'children' => [
                    ['name' => 'Sales Tax Payable (5%)', 'balance' => $salesTax],
                    ['name' => 'Unearned Revenue (Pending)', 'balance' => $unearned],
                ],
            ],
            'income' => [
                'name' => 'Revenue',
                'balance' => $salesRevenue,
                'children' => [
                    ['name' => 'Store Product Sales', 'balance' => $salesRevenue],
                ],
            ],
            'expenses' => [
                'name' => 'Expenses',
                'balance' => $cogs + $gateway + $shipping,
                'children' => [
                    ['name' => 'Cost of Goods Sold (60% Est.)', 'balance' => $cogs],
                    ['name' => 'Gateway Processing Fees (3%)', 'balance' => $gateway],
                    ['name' => 'Shipping & Fulfillment (5% Est.)', 'balance' => $shipping],
                ],
            ],
        ];
    }

    public function index()
    {
        return view('admin.reports.index');
    }

    public function financial()
    {
        $monthlyRevenue = Booking::select(
            DB::raw('sum(total_price) as total_sales'),
            DB::raw("DATE_FORMAT(created_at, '%M %Y') as month")
        )
        ->where('status', 'completed')
        ->groupBy('month')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($row) {
            $row->total_cogs = $row->total_sales * 0.60;
            $row->total_profit = $row->total_sales * 0.32;
            return $row;
        });

        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $totalCOGS = $totalRevenue * 0.60;
        $totalNetProfit = $totalRevenue * 0.32;

        return view('admin.reports.financial', compact('monthlyRevenue', 'totalRevenue', 'totalCOGS', 'totalNetProfit'));
    }

    public function vendorPerformance()
    {
        $products = Service::withCount(['bookings as total_orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['bookings as total_sales' => function($query) {
                $query->where('status', 'completed');
            }], 'total_price')
            ->with('category')
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                return $product;
            })
            ->sortByDesc('total_sales')
            ->values();

        return view('admin.reports.vendor-performance', compact('products'));
    }

    public function salesByCategory()
    {
        $categories = ServiceCategory::withCount(['services as total_services'])
            ->with(['services.bookings' => function($query) {
                $query->where('status', 'completed');
            }])->get();

        $categorySales = $categories->map(function ($category) {
            $totalSales = $category->services->sum(function ($service) {
                return $service->bookings->sum('total_price');
            });
            $totalBookings = $category->services->sum(function ($service) {
                return $service->bookings->count();
            });

            return [
                'name' => $category->name,
                'total_services' => $category->total_services,
                'total_sales' => $totalSales,
                'total_bookings' => $totalBookings,
            ];
        })->sortByDesc('total_sales')->values();

        return view('admin.reports.sales-by-category', compact('categorySales'));
    }

    public function bookingStatus()
    {
        $statuses = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalBookings = array_sum($statuses);

        return view('admin.reports.booking-status', compact('statuses', 'totalBookings'));
    }
}
