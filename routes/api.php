<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Admin\UserManagementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogPostController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ContactQueryController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\CustomerDashboardController;
use App\Http\Controllers\API\HeroSectionController;
use App\Http\Controllers\API\HomeBestSellingProductController;
use App\Http\Controllers\API\HomeBlogPostController;
use App\Http\Controllers\API\HomeHeroSectionController;
use App\Http\Controllers\API\HomeShopByCategoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductVariantController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });
});

Route::prefix('home')->group(function () {
    Route::get('/hero-sections', [HomeHeroSectionController::class, 'index']);
    Route::get('/bestselling-products', [HomeBestSellingProductController::class, 'index']);
    Route::get('/shop-by-category', [HomeShopByCategoryController::class, 'index']);
    Route::get('/blogs', [HomeBlogPostController::class, 'index']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/categories/{category}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/{id}/variants', [ProductVariantController::class, 'index']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'productReviews']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/coupons', [CouponController::class, 'index']);
Route::post('/contact-queries', [ContactQueryController::class, 'store']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{blogPost}', [BlogPostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::get('/addresses/{id}', [AddressController::class, 'show']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault']);

    Route::post('/categories', [CategoryController::class, 'store'])->middleware('admin.api_permission:categories.create');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('admin.api_permission:categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('admin.api_permission:categories.delete');

    Route::post('/products', [ProductController::class, 'store'])->middleware('admin.api_permission:products.create');
    Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('admin.api_permission:products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('admin.api_permission:products.delete');

    Route::post('/variants', [ProductVariantController::class, 'store'])->middleware('admin.api_permission:products.update');
    Route::put('/variants/{id}', [ProductVariantController::class, 'update'])->middleware('admin.api_permission:products.update');
    Route::delete('/variants/{id}', [ProductVariantController::class, 'destroy'])->middleware('admin.api_permission:products.delete');

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);

    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::get('/orders/{id}/track', [OrderController::class, 'track']);

    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{order_id}', [PaymentController::class, 'show']);

    Route::post('/coupons/apply', [CouponController::class, 'apply']);
    Route::post('/coupons', [CouponController::class, 'store'])->middleware('admin.api_permission:coupons.create');
    Route::get('/coupons/{coupon}', [CouponController::class, 'show'])->middleware('admin.api_permission:coupons.view');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->middleware('admin.api_permission:coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->middleware('admin.api_permission:coupons.delete');

    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    Route::get('/users', [UserManagementController::class, 'index'])->middleware('admin.api_permission:users.view');
    Route::post('/users', [UserManagementController::class, 'store'])->middleware('admin.api_permission:users.create');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->middleware('admin.api_permission:users.view');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->middleware('admin.api_permission:users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->middleware('admin.api_permission:users.delete');

    Route::get('/roles', [AdminRoleController::class, 'index'])->middleware('admin.api_permission:roles.view');
    Route::get('/roles/options', [AdminRoleController::class, 'options'])->middleware('admin.api_permission:users.view');
    Route::post('/roles', [AdminRoleController::class, 'store'])->middleware('admin.api_permission:roles.create');
    Route::get('/roles/{role}', [AdminRoleController::class, 'show'])->middleware('admin.api_permission:roles.view');
    Route::put('/roles/{role}', [AdminRoleController::class, 'update'])->middleware('admin.api_permission:roles.update');
    Route::delete('/roles/{role}', [AdminRoleController::class, 'destroy'])->middleware('admin.api_permission:roles.delete');

    Route::get('/hero-sections', [HeroSectionController::class, 'index'])->middleware('admin.api_permission:hero_sections.view');
    Route::post('/hero-sections', [HeroSectionController::class, 'store'])->middleware('admin.api_permission:hero_sections.create');
    Route::get('/hero-sections/{heroSection}', [HeroSectionController::class, 'show'])->middleware('admin.api_permission:hero_sections.view');
    Route::put('/hero-sections/{heroSection}', [HeroSectionController::class, 'update'])->middleware('admin.api_permission:hero_sections.update');
    Route::delete('/hero-sections/{heroSection}', [HeroSectionController::class, 'destroy'])->middleware('admin.api_permission:hero_sections.delete');

    Route::post('/blog-posts', [BlogPostController::class, 'store'])->middleware('admin.api_permission:blogs.create');
    Route::put('/blog-posts/{blogPost}', [BlogPostController::class, 'update'])->middleware('admin.api_permission:blogs.update');
    Route::delete('/blog-posts/{blogPost}', [BlogPostController::class, 'destroy'])->middleware('admin.api_permission:blogs.delete');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('admin.api_permission:dashboard.view');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->middleware('admin.api_permission:dashboard.view');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->middleware('admin.api_permission:users.view');
    Route::get('/admin/products/{id}', [ProductController::class, 'adminShow'])->middleware('admin.api_permission:products.view');
    Route::get('/admin/coupons', [CouponController::class, 'adminIndex'])->middleware('admin.api_permission:coupons.view');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->middleware('admin.api_permission:orders.view');
    Route::get('/admin/orders/{id}', [AdminController::class, 'showOrder'])->middleware('admin.api_permission:orders.view');
    Route::put('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->middleware('admin.api_permission:orders.update');
    Route::get('/admin/reviews', [ReviewController::class, 'adminIndex'])->middleware('admin.api_permission:reviews.view');
    Route::get('/admin/reviews/{id}', [ReviewController::class, 'adminShow'])->middleware('admin.api_permission:reviews.view');
    Route::delete('/admin/reviews/{id}', [ReviewController::class, 'adminDestroy'])->middleware('admin.api_permission:reviews.delete');
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex'])->middleware('admin.api_permission:payments.view');
    Route::get('/admin/payments/{id}', [PaymentController::class, 'adminShow'])->middleware('admin.api_permission:payments.view');
    Route::put('/admin/payments/{id}', [PaymentController::class, 'adminUpdate'])->middleware('admin.api_permission:payments.update');
    Route::get('/admin/carts', [CartController::class, 'adminIndex'])->middleware('admin.api_permission:carts.view');
    Route::get('/admin/carts/{id}', [CartController::class, 'adminShow'])->middleware('admin.api_permission:carts.view');
    Route::get('/admin/wishlists', [WishlistController::class, 'adminIndex'])->middleware('admin.api_permission:wishlists.view');
    Route::delete('/admin/wishlists/{id}', [WishlistController::class, 'adminDestroy'])->middleware('admin.api_permission:wishlists.delete');
});



