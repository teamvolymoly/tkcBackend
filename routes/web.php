<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HeroSectionController as AdminHeroSectionController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WishlistController as AdminWishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/media/public/{path}', [MediaController::class, 'public'])
    ->where('path', '.*')
    ->name('media.public');

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

            Route::get('/', AdminDashboardController::class)->middleware('admin.permission:dashboard.view')->name('dashboard');
            Route::get('/analytics', AdminAnalyticsController::class)->middleware('admin.permission:dashboard.view')->name('analytics');
            Route::get('/profile', [AdminAuthController::class, 'profile'])->middleware('admin.permission:profile.view')->name('profile.show');
            Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->middleware('admin.permission:profile.update')->name('profile.update');

            Route::middleware('admin.permission:categories.view')->group(function () {
                Route::resource('categories', AdminCategoryController::class)->except('show');
            });
            Route::post('/categories/bulk-delete', [AdminCategoryController::class, 'bulkDestroy'])->middleware('admin.permission:categories.delete')->name('categories.bulk-delete');
            Route::post('/categories/quick-store', [AdminCategoryController::class, 'quickStore'])->middleware('admin.permission:categories.create')->name('categories.quick-store');

            Route::middleware('admin.permission:products.view')->group(function () {
                Route::resource('products', AdminProductController::class);
            });
            Route::post('/products/bulk-delete', [AdminProductController::class, 'bulkDestroy'])->middleware('admin.permission:products.delete')->name('products.bulk-delete');
            Route::post('/products/{product}/variants/{variant}/images', [AdminProductController::class, 'storeVariantImage'])->middleware('admin.permission:products.update')->name('products.variants.images.store');
            Route::put('/products/{product}/variants/{variant}/images/{image}', [AdminProductController::class, 'updateVariantImage'])->middleware('admin.permission:products.update')->name('products.variants.images.update');
            Route::delete('/products/{product}/variants/{variant}/images/{image}', [AdminProductController::class, 'destroyVariantImage'])->middleware('admin.permission:products.delete')->name('products.variants.images.destroy');
            Route::post('/products/{product}/ingredients', [AdminProductController::class, 'storeIngredient'])->middleware('admin.permission:products.update')->name('products.ingredients.store');
            Route::put('/products/{product}/ingredients/{ingredient}', [AdminProductController::class, 'updateIngredient'])->middleware('admin.permission:products.update')->name('products.ingredients.update');
            Route::delete('/products/{product}/ingredients/{ingredient}', [AdminProductController::class, 'destroyIngredient'])->middleware('admin.permission:products.delete')->name('products.ingredients.destroy');
            Route::post('/products/{product}/nutrition', [AdminProductController::class, 'storeNutrition'])->middleware('admin.permission:products.update')->name('products.nutrition.store');
            Route::put('/products/{product}/nutrition/{nutrition}', [AdminProductController::class, 'updateNutrition'])->middleware('admin.permission:products.update')->name('products.nutrition.update');
            Route::delete('/products/{product}/nutrition/{nutrition}', [AdminProductController::class, 'destroyNutrition'])->middleware('admin.permission:products.delete')->name('products.nutrition.destroy');

            Route::get('/inventory', [AdminInventoryController::class, 'index'])->middleware('admin.permission:inventory.view')->name('inventory.index');
            Route::put('/inventory/{variant}', [AdminInventoryController::class, 'update'])->middleware('admin.permission:inventory.update')->name('inventory.update');

            Route::resource('coupons', AdminCouponController::class)->middleware('admin.permission:coupons.view');
            Route::resource('users', AdminUserController::class)->only(['index', 'store', 'show', 'edit', 'update', 'destroy'])->middleware('admin.permission:users.view');
            Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDestroy'])->middleware('admin.permission:users.delete')->name('users.bulk-delete');

            Route::get('/orders', [AdminOrderController::class, 'index'])->middleware('admin.permission:orders.view')->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->middleware('admin.permission:orders.view')->name('orders.show');
            Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->middleware('admin.permission:orders.update')->name('orders.status');
            Route::post('/orders/bulk-status', [AdminOrderController::class, 'bulkUpdateStatus'])->middleware('admin.permission:orders.update')->name('orders.bulk-status');

            Route::get('/reviews', [AdminReviewController::class, 'index'])->middleware('admin.permission:reviews.view')->name('reviews.index');
            Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->middleware('admin.permission:reviews.view')->name('reviews.show');
            Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->middleware('admin.permission:reviews.delete')->name('reviews.destroy');

            Route::get('/payments', [AdminPaymentController::class, 'index'])->middleware('admin.permission:payments.view')->name('payments.index');
            Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->middleware('admin.permission:payments.view')->name('payments.show');
            Route::put('/payments/{payment}', [AdminPaymentController::class, 'update'])->middleware('admin.permission:payments.update')->name('payments.update');

            Route::get('/carts', [AdminCartController::class, 'index'])->middleware('admin.permission:carts.view')->name('carts.index');
            Route::get('/carts/{cart}', [AdminCartController::class, 'show'])->middleware('admin.permission:carts.view')->name('carts.show');

            Route::get('/wishlists', [AdminWishlistController::class, 'index'])->middleware('admin.permission:wishlists.view')->name('wishlists.index');
            Route::delete('/wishlists/{wishlist}', [AdminWishlistController::class, 'destroy'])->middleware('admin.permission:wishlists.delete')->name('wishlists.destroy');

            Route::resource('blogs', AdminBlogPostController::class)->middleware('admin.permission:blogs.view');
            Route::get('/hero-sections', [AdminHeroSectionController::class, 'index'])->middleware('admin.permission:hero_sections.view')->name('hero-sections.index');
            Route::get('/hero-sections/create', [AdminHeroSectionController::class, 'create'])->middleware('admin.permission:hero_sections.create')->name('hero-sections.create');
            Route::post('/hero-sections', [AdminHeroSectionController::class, 'store'])->middleware('admin.permission:hero_sections.create')->name('hero-sections.store');
            Route::get('/hero-sections/{heroSection}', [AdminHeroSectionController::class, 'show'])->middleware('admin.permission:hero_sections.view')->name('hero-sections.show');
            Route::get('/hero-sections/{heroSection}/edit', [AdminHeroSectionController::class, 'edit'])->middleware('admin.permission:hero_sections.update')->name('hero-sections.edit');
            Route::put('/hero-sections/{heroSection}', [AdminHeroSectionController::class, 'update'])->middleware('admin.permission:hero_sections.update')->name('hero-sections.update');
            Route::delete('/hero-sections/{heroSection}', [AdminHeroSectionController::class, 'destroy'])->middleware('admin.permission:hero_sections.delete')->name('hero-sections.destroy');

            Route::get('/roles', [AdminRoleController::class, 'index'])->middleware('admin.permission:roles.view')->name('roles.index');
            Route::post('/roles', [AdminRoleController::class, 'store'])->middleware('admin.permission:roles.create')->name('roles.store');
            Route::get('/roles/{role}/edit', [AdminRoleController::class, 'edit'])->middleware('admin.permission:roles.update')->name('roles.edit');
            Route::put('/roles/{role}', [AdminRoleController::class, 'update'])->middleware('admin.permission:roles.update')->name('roles.update');
            Route::delete('/roles/{role}', [AdminRoleController::class, 'destroy'])->middleware('admin.permission:roles.delete')->name('roles.destroy');
        });
    });
});

