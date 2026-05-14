<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\PaymentController;


// ── Registration ───────────────────────────────────────────────
Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// ── Login / Logout ─────────────────────────────────────────────
Route::get('/login',   [LoginController::class, 'showForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/admin', function () {
    return redirect()->route('admin.login.form');
});
// ── Home (auth only) ───────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// ── Email Verification ─────────────────────────────────────────
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = \App\Models\User::findOrFail($request->route('id'));
    if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }
    return redirect()->route('home')->with('status', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ── Forgot Password (3-step OTP flow) ─────────────────────────
// Step 1 — Find account
Route::get('/forgot-password',         [ForgotPasswordController::class, 'showFindForm'])->name('password.request');
Route::post('/forgot-password',        [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');

// Step 2 — Verify OTP  ✅ GET and POST now have DIFFERENT names
Route::get('/forgot-password/verify',  [ForgotPasswordController::class, 'showVerifyForm'])->name('password.otp-form');
Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');

// Step 3 — Reset password
Route::get('/forgot-password/reset',   [ForgotPasswordController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/forgot-password/reset',  [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// Resend OTP
Route::post('/forgot-password/resend', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend-otp');

// ── Products ───────────────────────────────────────────────────
use App\Http\Controllers\ProductController;

Route::middleware(['auth'])->group(function () {
    Route::get('/products',      [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

// ── Shopping Cart ──────────────────────────────────────────────
use App\Http\Controllers\CartController;
use App\Http\Controllers\SavedItemController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cart',          [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',     [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update',  [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove',  [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',   [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/apply-coupon', [App\Http\Controllers\CheckoutController::class, 'applyCoupon'])
        ->name('apply.coupon');
    Route::post('/coupon/apply', [App\Http\Controllers\CouponController::class, 'apply'])
        ->name('coupon.apply');
    Route::post('/coupon/remove', [App\Http\Controllers\CouponController::class, 'remove'])
        ->name('coupon.remove');
    Route::post('/coupon/check', [App\Http\Controllers\CouponController::class, 'check'])
        ->name('coupon.check');
    Route::get('/cart/count',    [CartController::class, 'count'])->name('cart.count');

   Route::post('/cart/save/{productId}', [CartController::class, 'saveForLater'])
    ->name('cart.save');

Route::get('/saved-items', [SavedItemController::class, 'index'])
    ->name('saved.items');

Route::delete('/saved-items/{id}', [SavedItemController::class, 'remove'])
    ->name('saved.remove');

// Route::get('/saved-items', [SavedItemController::class, 'index'])->name('saved.items');

// Route::post('/save-product/{productId}', [SavedItemController::class, 'store'])->name('save.product');

// Route::delete('/saved-items/{id}', [SavedItemController::class, 'destroy'])->name('saved.remove');
});

// ── Checkout ───────────────────────────────────────────────────
use App\Http\Controllers\CheckoutController;

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout',                    [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order',       [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ── Orders ─────────────────────────────────────────────────────
use App\Http\Controllers\OrderController;

Route::middleware(['auth'])->group(function () {
    Route::get('/orders',                      [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}',        [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{orderNumber}/cancel',[OrderController::class, 'cancel'])->name('orders.cancel');
     Route::delete('/order-item/{id}', [OrderController::class, 'removeItem'])
        ->name('admin.order.item.remove');
});

// ── Profile ─────────────────────────────────────────────────────
use App\Http\Controllers\ProfileController;
 
Route::middleware(['auth'])->group(function () {
    Route::get('/profile',                  [ProfileController::class, 'index'])->name('profile.index');
 
    Route::get('/profile/edit-name',        [ProfileController::class, 'editName'])->name('profile.edit-name');
    Route::post('/profile/edit-name',       [ProfileController::class, 'updateName'])->name('profile.update-name');
 
    Route::get('/profile/edit-email',       [ProfileController::class, 'editEmail'])->name('profile.edit-email');
    Route::post('/profile/edit-email',      [ProfileController::class, 'updateEmail'])->name('profile.update-email');
 
    Route::get('/profile/edit-password',    [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::post('/profile/edit-password',   [ProfileController::class, 'updatePassword'])->name('profile.update-password');
 
    Route::get('/profile/edit-mobile',      [ProfileController::class, 'editMobile'])->name('profile.edit-mobile');
    Route::post('/profile/edit-mobile',     [ProfileController::class, 'updateMobile'])->name('profile.update-mobile');

    // Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    // // Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])
    // // ->name('profile.address.store')
    // // ->middleware('auth');
    //  Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])->name('profile.address.store');

     // Payment Options
    Route::get('/profile/payment', [ProfileController::class, 'payment'])->name('profile.payment');
    Route::post('/profile/payment', [ProfileController::class, 'storePayment'])->name('profile.payment.store');
    Route::put('/profile/payment/{paymentMethod}', [ProfileController::class, 'updatePayment'])->name('profile.payment.update');
    Route::delete('/profile/payment/{paymentMethod}', [ProfileController::class, 'destroyPayment'])->name('profile.payment.destroy');
    Route::post('/profile/payment/{paymentMethod}/setDefault', [ProfileController::class, 'setDefaultPayment'])->name('profile.payment.setDefault');

    // // Wishlist
    // Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    // Route::post('/profile/wishlist', [ProfileController::class, 'addToWishlist'])->name('profile.wishlist.store');
    // Route::put('/profile/wishlist/{wishlist}', [ProfileController::class, 'updateWishlist'])->name('profile.wishlist.update');
    // Route::delete('/profile/wishlist/{wishlist}', [ProfileController::class, 'removeFromWishlist'])->name('profile.wishlist.destroy');
    // Route::post('/profile/wishlist/{wishlist}/move-to-cart', [ProfileController::class, 'moveToCart'])->name('profile.wishlist.move-to-cart');

    // Gift Cards
    Route::get('/profile/gift-cards', [ProfileController::class, 'giftCards'])->name('profile.gift-cards');
    Route::post('/profile/gift-cards', [ProfileController::class, 'addGiftCard'])->name('profile.gift-cards.store');
    Route::put('/profile/gift-cards/{giftCard}', [ProfileController::class, 'updateGiftCard'])->name('profile.gift-cards.update');
    Route::delete('/profile/gift-cards/{giftCard}', [ProfileController::class, 'deleteGiftCard'])->name('profile.gift-cards.destroy');

    // Customer Support
    Route::get('/profile/customer-support', [ProfileController::class, 'customerSupport'])->name('profile.customer-support');
    Route::post('/profile/customer-support', [ProfileController::class, 'createSupportTicket'])->name('profile.customer-support.store');
    Route::put('/profile/customer-support/{customerSupport}', [ProfileController::class, 'updateSupportTicket'])->name('profile.customer-support.update');
    Route::post('/profile/customer-support/{customerSupport}/close', [ProfileController::class, 'closeSupportTicket'])->name('profile.customer-support.close');

      // Customer Support Notifications
    Route::get('/profile/customer-support-notifications', [ProfileController::class, 'customerSupportNotifications'])->name('profile.customer-support-notifications');
    Route::post('/profile/customer-support-notifications/{notificationId}/read', [ProfileController::class, 'markNotificationAsRead'])->name('profile.customer-support-notifications.read');
    Route::post('/profile/customer-support-notifications/mark-all-read', [ProfileController::class, 'markAllNotificationsAsRead'])->name('profile.customer-support-notifications.mark-all-read');
    Route::post('/profile/customer-support-notifications/{notificationId}/delete', [ProfileController::class, 'deleteNotification'])->name('profile.customer-support-notifications.delete');

    // REGISTRY ROUTES
Route::get('/profile/registry', [ProfileController::class, 'registry'])
    ->name('profile.registry');

Route::post('/profile/registry/create', [ProfileController::class, 'createRegistry'])
    ->name('profile.registry.create');

Route::post('/profile/registry/{id}/delete', [ProfileController::class, 'deleteRegistry'])
    ->name('profile.registry.delete');

   Route::get('/profile/sell', [ProfileController::class, 'sell'])
    ->name('profile.sell');
   Route::post('/profile/sell', [ProfileController::class, 'storeProduct'])
    ->name('profile.sell.store');
    // ── Admin Panel ─────────────────────────────────────────────────

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
 
    //   Route::post('/logout', [AdminAuthController::class, 'logout'])
    //     ->name('logout');

    // Dashboard
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
 
    // Products
    Route::get('/products',              [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',       [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products',             [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit',[AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',    [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
 
    // Orders
    Route::get('/orders',                        [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',                [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status',       [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
     // 📄 Invoice (ADMIN)
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'adminDownload'])->name('invoice.download');
        // Route::delete('admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
 
    // Users
    Route::get('/users',                         [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-admin',   [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::delete('/users/{user}',               [AdminUserController::class, 'destroy'])->name('users.destroy');

    
});

// ── Wishlist ───────────────────────────────────────────────────

 
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist',               [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle',       [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/remove',       [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
    Route::post('/wishlist/move-all',     [WishlistController::class, 'moveAllToCart'])->name('wishlist.move-all');
    Route::get('/wishlist/count',         [WishlistController::class, 'count'])->name('wishlist.count');
});
 
// ── Reviews ────────────────────────────────────────────────────

 
Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}/review',  [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}',        [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/helpful',  [ReviewController::class, 'helpful'])->name('reviews.helpful');
});

// ── Admin Coupons ──────────────────────────────────────────────
 
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/coupons',              [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create',       [AdminCouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons',             [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}/edit',[AdminCouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}',     [AdminCouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}',  [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
    Route::patch('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
});

// ── USER SIDE COUPON APPLY ─────────────────────
Route::post('/apply-coupon', [App\Http\Controllers\CheckoutController::class, 'applyCoupon'])
    ->name('apply.coupon');
});

// ── Address Book ───────────────────────────────────────────────
use App\Http\Controllers\AddressController;
 
Route::middleware(['auth'])->group(function () {
    Route::get('/addresses',                    [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create',             [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses',                   [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}/edit',     [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}',          [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}',       [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::patch('/addresses/{address}/default',[AddressController::class, 'setDefault'])->name('addresses.default');
    Route::get('/addresses/list',               [AddressController::class, 'list'])->name('addresses.list');
});

Route::view('/conditions', 'footer.conditions')->name('conditions');
Route::view('/privacy', 'footer.privacy')->name('privacy');
Route::view('/help', 'footer.help')->name('help');
Route::view('/careers', 'footer.careers')->name('careers');
Route::view('/press', 'footer.press')->name('press');

// Route::view('/conditions', 'conditions');
// Route::view('/privacy', 'privacy');

// ── Search ─────────────────────────────────────────────────────
use App\Http\Controllers\SearchController;
 
Route::get('/search', [SearchController::class, 'results'])->name('search.results');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

Route::get('/search/history', function () {
    return response()->json([
        'history' => session('search_history', [])
    ]);
})->name('search.history');

Route::post('/search/history/clear', function () {
    session()->forget('search_history');
    return response()->json(['success' => true]);
})->name('search.clear-history');

// ── Payment (Razorpay) ─────────────────────────────────────────
// use App\Http\Controllers\PaymentController;
 
// Route::middleware(['auth'])->group(function () {
//     Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
//     Route::post('/payment/verify',       [PaymentController::class, 'verify'])->name('payment.verify');
//     Route::get('/payment/failed',        [PaymentController::class, 'failed'])->name('payment.failed');
// });
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
    Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::get('/payment/razorpay', function() {
        $pending = session('pending_order');
        if (!$pending) {
            return redirect()->route('checkout.index')->with('error', 'Session expired');
        }
        
        return view('payment.razorpay', [
            'total' => $pending['total'],
            'amount' => $pending['total'] * 100,
            'currency' => 'INR',
            'name' => 'CartNova',
            'description' => 'Order Payment',
            'razorpayOrderId' => request()->get('order_id'),
            'key' => request()->get('key'),
            'prefill_name' => $pending['full_name'],
            'prefill_email' => $pending['email'],
            'prefill_phone' => $pending['phone'],
        ]);
    })->name('payment.razorpay');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
});
// ── Notifications ──────────────────────────────────────────────
use App\Http\Controllers\NotificationController;
 
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications',                     [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/count',               [NotificationController::class, 'count'])->name('notifications.count');
    Route::get('/notifications/recent',              [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::patch('/notifications/{notification}/read',[NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read',      [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}',   [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear-all',        [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
});
// ── Invoice ────────────────────────────────────────────────────
// use App\Http\Controllers\InvoiceController;
 
Route::middleware(['auth'])->group(function () {
    Route::get('/orders/{orderNumber}/invoice', [InvoiceController::class, 'download'])->name('invoice.download');
});
 
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'adminDownload'])->name('invoice.download');
});
// ── Admin Authentication ────────────────────────────────────────
// Admin Login (PUBLIC)
// use App\Http\Controllers\Admin\AdminAuthController;
// Admin Login (Public)
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login.form');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.submit');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout')
         ->middleware(['auth','admin']);
});

use App\Http\Controllers\ReturnController;

// USER
Route::post('/return-request', [ReturnController::class, 'store'])
    ->name('return.request');

// ADMIN
Route::get('/admin/returns', [ReturnController::class, 'index'])
    ->name('admin.returns');

Route::post('/admin/returns/{id}', [ReturnController::class, 'update'])
    ->name('admin.return.update');