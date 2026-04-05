<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WishlistController as AdminWishlistController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('web')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
        Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/forgot-password', [AdminAuthController::class, 'sendResetOtp'])->name('password.email');
        Route::get('/verify-otp', [AdminAuthController::class, 'showOtpVerificationForm'])->name('password.otp');
        Route::post('/verify-otp', [AdminAuthController::class, 'verifyResetOtp'])->name('password.otp.verify');
        Route::get('/reset-password', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password', [AdminAuthController::class, 'updatePassword'])->name('password.update');

        Route::middleware('admin.session')->group(function () {
            Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
            Route::get('/', AdminDashboardController::class)->name('dashboard');
            Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile.show');
            Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');

            Route::post('/categories/bulk-delete', [AdminCategoryController::class, 'bulkDestroy'])->name('categories.bulk-delete');
            Route::resource('categories', AdminCategoryController::class)->except('show');

            Route::post('/products/bulk-delete', [AdminProductController::class, 'bulkDestroy'])->name('products.bulk-delete');
            Route::post('/products/{product}/variants/{variant}/images', [AdminProductController::class, 'storeVariantImage'])->name('products.variants.images.store');
            Route::put('/products/{product}/variants/{variant}/images/{image}', [AdminProductController::class, 'updateVariantImage'])->name('products.variants.images.update');
            Route::delete('/products/{product}/variants/{variant}/images/{image}', [AdminProductController::class, 'destroyVariantImage'])->name('products.variants.images.destroy');
            Route::post('/products/{product}/ingredients', [AdminProductController::class, 'storeIngredient'])->name('products.ingredients.store');
            Route::put('/products/{product}/ingredients/{ingredient}', [AdminProductController::class, 'updateIngredient'])->name('products.ingredients.update');
            Route::delete('/products/{product}/ingredients/{ingredient}', [AdminProductController::class, 'destroyIngredient'])->name('products.ingredients.destroy');
            Route::post('/products/{product}/nutrition', [AdminProductController::class, 'storeNutrition'])->name('products.nutrition.store');
            Route::put('/products/{product}/nutrition/{nutrition}', [AdminProductController::class, 'updateNutrition'])->name('products.nutrition.update');
            Route::delete('/products/{product}/nutrition/{nutrition}', [AdminProductController::class, 'destroyNutrition'])->name('products.nutrition.destroy');
            Route::resource('products', AdminProductController::class);

            Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
            Route::put('/inventory/{variant}', [AdminInventoryController::class, 'update'])->name('inventory.update');

            Route::resource('coupons', AdminCouponController::class);

            Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDestroy'])->name('users.bulk-delete');
            Route::resource('users', AdminUserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

            Route::post('/orders/bulk-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-status');
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
            Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

            Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
            Route::put('/payments/{payment}', [AdminPaymentController::class, 'update'])->name('payments.update');

            Route::get('/carts', [AdminCartController::class, 'index'])->name('carts.index');
            Route::get('/carts/{cart}', [AdminCartController::class, 'show'])->name('carts.show');

            Route::get('/wishlists', [AdminWishlistController::class, 'index'])->name('wishlists.index');
            Route::delete('/wishlists/{wishlist}', [AdminWishlistController::class, 'destroy'])->name('wishlists.destroy');
        });
    });
});
