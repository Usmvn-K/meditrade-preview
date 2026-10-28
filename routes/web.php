<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceDeskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BudgetPlannerController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CustomPackageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;


// Service Desk Public Route
Route::post('/service-desk/request', [ServiceDeskController::class, 'store'])
    ->middleware('throttle:form')
    ->name('service-desk.store');

// Shopping Cart Routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/data', [\App\Http\Controllers\CartController::class, 'getCart'])->name('cart.data');
Route::match(['get', 'post'], '/add-to-cart/{service}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::get('/buy-now/{service}', [\App\Http\Controllers\CartController::class, 'buyNow'])->name('cart.buyNow');
Route::match(['patch', 'post'], '/update-cart', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::match(['delete', 'post'], '/remove-from-cart', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/cart/place-order', [\App\Http\Controllers\CartController::class, 'placeOrder'])->name('cart.placeOrder');

// Admin Service Desk Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/service-desk', [ServiceDeskController::class, 'index'])->name('service-desk.index');
    Route::get('/service-desk/{request}', [ServiceDeskController::class, 'show'])->name('service-desk.show');
    Route::post('/service-desk/{request}/assign', [ServiceDeskController::class, 'assign'])->name('service-desk.assign');
    Route::patch('/service-desk/{request}/status', [ServiceDeskController::class, 'updateStatus'])->name('service-desk.status');
});



Route::get('/blueprint', [\App\Http\Controllers\BlueprintController::class, 'index'])->name('blueprint');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('/home', [HomeController::class, 'index']); // Keep /home as legacy if needed

// Public Vendor Profiles
Route::get('/vendors/{vendor:id}', [\App\Http\Controllers\PublicVendorController::class, 'show'])->name('vendors.show');

// Public Pages
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/desks/{slug}', [PageController::class, 'desk'])->name('desk.show');
Route::get('/services/{service}/check-availability', [BookingController::class, 'checkAvailability'])->name('services.check-availability');
Route::get('/services/{service}/unavailable-dates', [BookingController::class, 'getUnavailableDates'])->name('services.unavailable-dates');
Route::get('/services/{service}', [PageController::class, 'showService'])->name('services.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:form')
    ->name('contact.store');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/budget-planner', [BudgetPlannerController::class, 'index'])->name('budget-planner');
Route::get('/budget-planner/preview', [BudgetPlannerController::class, 'preview'])->name('budget-planner.preview');
Route::post('/budget-planner', [BudgetPlannerController::class, 'store'])
    ->middleware('throttle:form')
    ->name('budget-planner.store');
Route::post('/budget-planner/{budgetRequest}/acquire', [BudgetPlannerController::class, 'acquire'])->name('budget-planner.acquire');
Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:form')
    ->name('newsletter.store');

// New Ecosystem Routes
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('refund-policy');
// Route::get('/vendor-onboarding', [PageController::class, 'vendorOnboarding'])->name('vendor-onboarding');
// Route::get('/individual', [PageController::class, 'individual'])->name('individual');
// Route::get('/corporate', [PageController::class, 'corporate'])->name('corporate');


// User Booking Routes (Now Public for Guest Checkout)
Route::get('/services/{service}/book', [BookingController::class, 'create'])->name('services.book');
Route::post('/services/{service}/book', [BookingController::class, 'store'])->name('services.store_booking');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/invoice', [BookingController::class, 'downloadInvoice'])->name('bookings.invoice');
    
    // Payments
    Route::post('/bookings/{booking}/pay', [\App\Http\Controllers\PaymentController::class, 'createCheckoutSession'])->name('payment.checkout');
    Route::get('/payment/success/{booking}', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{booking}', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::post('/bookings/{booking}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('bookings.reviews.store');
    Route::post('/reviews/{review}/reply', [\App\Http\Controllers\ReviewController::class, 'reply'])->name('reviews.reply');
    Route::post('/reviews/{review}/like', [\App\Http\Controllers\ReviewController::class, 'toggleLike'])->name('reviews.like');
    Route::get('/my-packages', [CustomPackageController::class, 'myPackages'])->name('my-packages');
    Route::get('/my-packages/{booking}', [CustomPackageController::class, 'showBooking'])->name('my-packages.show');
    
    // Chat Routes
    Route::get('/messages/{receiver?}', [ChatController::class, 'index'])->name('messages.index');
    Route::post('/messages/{receiver}', [ChatController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/{receiver}/updates', [ChatController::class, 'getUpdates'])->name('messages.updates');
    Route::get('/unread-messages-count', [ChatController::class, 'getUnreadCount'])->name('messages.unread-count');
    
    // Custom Package Management
    Route::get('/build-package', [CustomPackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [CustomPackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/book', [CustomPackageController::class, 'book'])->name('packages.book');
    Route::post('/packages/{package}/book', [CustomPackageController::class, 'storeBooking'])->name('packages.store_booking');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [VendorController::class, 'analytics'])->name('analytics');
    Route::get('/profile', [VendorController::class, 'profile'])->name('profile');
    Route::post('/profile', [VendorController::class, 'updateProfile'])->name('profile.update');
    Route::get('/finance', [VendorController::class, 'finance'])->name('finance');
    Route::post('/withdraw', [VendorController::class, 'withdraw'])->name('withdraw');


    
    // Service Management
    Route::get('/create-service', [VendorController::class, 'createService'])->name('create-service');
    Route::post('/store-service', [VendorController::class, 'storeService'])->name('store-service');
    Route::get('/services/{service}/edit', [VendorController::class, 'editService'])->name('edit-service');
    Route::put('/services/{service}', [VendorController::class, 'updateService'])->name('update-service');
    Route::delete('/services/{service}', [VendorController::class, 'destroyService'])->name('destroy-service');
    
    // Availability Management
    Route::get('/services/{service}/availability', [\App\Http\Controllers\VendorAvailabilityController::class, 'index'])->name('services.availability');
    Route::get('/services/{service}/availability/fetch', [\App\Http\Controllers\VendorAvailabilityController::class, 'fetch'])->name('services.availability.fetch');
    Route::post('/services/{service}/availability', [\App\Http\Controllers\VendorAvailabilityController::class, 'store'])->name('services.availability.store');
    Route::delete('/availability/{availability}', [\App\Http\Controllers\VendorAvailabilityController::class, 'destroy'])->name('services.availability.destroy');
    
    // Orders
    Route::get('/orders', [BookingController::class, 'vendorIndex'])->name('orders');
    Route::get('/custom-orders', [VendorController::class, 'customOrders'])->name('custom-orders');
    Route::patch('/orders/{booking}/status', [BookingController::class, 'updateStatus'])->name('orders.update');
});

Route::middleware(['auth', 'role:corporate'])->prefix('corporate')->name('corporate.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\CorporateController::class, 'dashboard'])->name('dashboard');
});

/* 
Route::middleware(['auth', 'role:affiliate'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/leads', [\App\Http\Controllers\AffiliateController::class, 'leads'])->name('leads');
    Route::get('/commissions', [\App\Http\Controllers\AffiliateController::class, 'commissions'])->name('commissions');
    Route::get('/resources', [\App\Http\Controllers\AffiliateController::class, 'resources'])->name('resources');
});
*/

// Redirect /admin to /admin/dashboard
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'role:admin']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // E-Commerce (App) Management
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    Route::get('/app-orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('app_orders.index');
    Route::get('/app-orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('app_orders.show');
    Route::patch('/app-orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('app_orders.updateStatus');

    // Reports & Chart of Accounts
    Route::get('/chart-of-accounts', [ReportController::class, 'chartOfAccounts'])->name('chart-of-accounts');
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/vendor-performance', [ReportController::class, 'vendorPerformance'])->name('vendor-performance');
        Route::get('/sales-by-category', [ReportController::class, 'salesByCategory'])->name('sales-by-category');
        Route::get('/booking-status', [ReportController::class, 'bookingStatus'])->name('booking-status');
    });

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services/store', [AdminController::class, 'storeService'])->name('services.store');
    
    // AI Routes
    Route::post('/ai/optimize-description', [\App\Http\Controllers\AIController::class, 'optimizeDescription'])->name('ai.optimize-description');
    Route::post('/ai/suggest-images', [\App\Http\Controllers\AIController::class, 'suggestImages'])->name('ai.suggest-images');
    Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::post('/services/{service}/toggle', [AdminController::class, 'toggleFeature'])->name('services.toggle');
    Route::delete('/services/{service}', [AdminController::class, 'deleteService'])->name('services.delete');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.update');
    Route::resource('vendors', \App\Http\Controllers\Admin\VendorController::class)->except(['create', 'store', 'edit', 'update']);
    Route::post('/vendors/{vendor}/verify', [\App\Http\Controllers\Admin\VendorController::class, 'verify'])->name('vendors.verify');
    Route::get('/custom-packages', [AdminController::class, 'customPackages'])->name('custom-packages');
    Route::get('/custom-packages/{booking}', [AdminController::class, 'showCustomPackage'])->name('custom-packages.show');
    Route::get('/vendor-logs', [AdminController::class, 'vendorLogs'])->name('vendor-logs');
    Route::get('/budget-requests', [AdminController::class, 'budgetRequests'])->name('budget-requests');
    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::patch('/withdrawals/{withdrawal}', [AdminController::class, 'updateWithdrawalStatus'])->name('withdrawals.update');

    // Setup & Configuration
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('service-categories', \App\Http\Controllers\Admin\ServiceCategoryController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);
    Route::resource('sub-categories', \App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('features', \App\Http\Controllers\Admin\FeatureController::class);
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('wishlist.index');
    Route::post('/services/{service}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('services.favorite');
    
    // AI Chat
    Route::post('/ai/service-chat', [\App\Http\Controllers\AIController::class, 'serviceChat'])->name('ai.service-chat');
});

// Coupons (Publicly Accessible for Guest Checkout)
Route::post('/coupons/validate', [\App\Http\Controllers\CouponController::class, 'validateCoupon'])->name('coupons.validate');

// Webhook (Public)
Route::post('/webhooks/stripe', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');

require __DIR__.'/auth.php';

// Make cities resource route available globally (for navigation)
// Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

// --- Live Server Deployment Setup Helper ---
Route::get('/setup-live', function () {
    try {
        $output = "<h3>Live Server Setup Status:</h3><ul>";
        
        // 1. Storage Link
        $publicStorage = public_path('storage');
        if (file_exists($publicStorage)) {
            // Remove old link/directory if copied over from local
            if (is_link($publicStorage) || is_dir($publicStorage)) {
                @unlink($publicStorage);
                @rmdir($publicStorage);
            }
        }
        
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $output .= "<li style='color:green;'>✅ Storage symlink created successfully! Images will now work properly.</li>";
        
        // 2. Clear caches
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output .= "<li style='color:green;'>✅ Application caches cleared and optimized.</li>";
        
        // 3. Migrate database safely
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output .= "<li style='color:green;'>✅ Database migrations executed successfully.</li>";
        
        $output .= "</ul>";
        $output .= "<b>Setup Complete! You can now use your live website.</b>";
        
        return $output;
    } catch (\Exception $e) {
        return "<h3 style='color:red;'>Setup Failed:</h3><p>" . $e->getMessage() . "</p>";
    }
});
// require __DIR__.'/auth.php'; // Already required above
