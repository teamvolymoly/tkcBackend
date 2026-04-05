<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Admin\UserManagementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductIngredientController;
use App\Http\Controllers\API\ProductNutritionController;
use App\Http\Controllers\API\ProductVariantController;
use App\Http\Controllers\API\ProductVariantImageController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\WishlistController;

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

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/categories/{category}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/{id}/variants', [ProductVariantController::class, 'index']);
Route::get('/variants/{id}/images', [ProductVariantImageController::class, 'index']);
Route::get('/products/{id}/ingredients', [ProductIngredientController::class, 'index']);
Route::get('/products/{id}/nutrition', [ProductNutritionController::class, 'index']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'productReviews']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/coupons', [CouponController::class, 'index']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::get('/addresses/{id}', [AddressController::class, 'show']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault']);

    Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:admin');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('role:admin');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin');

    Route::post('/products', [ProductController::class, 'store'])->middleware('role:admin');
    Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('role:admin');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('role:admin');

    Route::post('/variants', [ProductVariantController::class, 'store'])->middleware('role:admin');
    Route::put('/variants/{id}', [ProductVariantController::class, 'update'])->middleware('role:admin');
    Route::delete('/variants/{id}', [ProductVariantController::class, 'destroy'])->middleware('role:admin');

    Route::post('/variant-images', [ProductVariantImageController::class, 'store'])->middleware('role:admin');
    Route::put('/variant-images/{id}', [ProductVariantImageController::class, 'update'])->middleware('role:admin');
    Route::delete('/variant-images/{id}', [ProductVariantImageController::class, 'destroy'])->middleware('role:admin');

    Route::post('/products/{id}/ingredients', [ProductIngredientController::class, 'store'])->middleware('role:admin');
    Route::put('/ingredients/{id}', [ProductIngredientController::class, 'update'])->middleware('role:admin');
    Route::delete('/ingredients/{id}', [ProductIngredientController::class, 'destroy'])->middleware('role:admin');

    Route::post('/products/{id}/nutrition', [ProductNutritionController::class, 'store'])->middleware('role:admin');
    Route::put('/nutrition/{id}', [ProductNutritionController::class, 'update'])->middleware('role:admin');
    Route::delete('/nutrition/{id}', [ProductNutritionController::class, 'destroy'])->middleware('role:admin');

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
    Route::post('/coupons', [CouponController::class, 'store'])->middleware('role:admin');
    Route::get('/coupons/{coupon}', [CouponController::class, 'show'])->middleware('role:admin');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->middleware('role:admin');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->middleware('role:admin');

    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    Route::get('/users', [UserManagementController::class, 'index'])->middleware('role:admin');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->middleware('role:admin');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->middleware('role:admin');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->middleware('role:admin');

    Route::middleware('role:admin')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index']);
        Route::put('/inventory/{variant_id}', [InventoryController::class, 'update']);

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/customers', [AdminController::class, 'customers']);
        Route::get('/admin/products/{id}', [ProductController::class, 'adminShow']);
        Route::get('/admin/coupons', [CouponController::class, 'adminIndex']);
        Route::get('/admin/orders', [AdminController::class, 'orders']);
        Route::get('/admin/orders/{id}', [AdminController::class, 'showOrder']);
        Route::put('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
        Route::get('/admin/reviews', [ReviewController::class, 'adminIndex']);
        Route::get('/admin/reviews/{id}', [ReviewController::class, 'adminShow']);
        Route::delete('/admin/reviews/{id}', [ReviewController::class, 'adminDestroy']);
        Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
        Route::get('/admin/payments/{id}', [PaymentController::class, 'adminShow']);
        Route::put('/admin/payments/{id}', [PaymentController::class, 'adminUpdate']);
        Route::get('/admin/carts', [CartController::class, 'adminIndex']);
        Route::get('/admin/carts/{id}', [CartController::class, 'adminShow']);
        Route::get('/admin/wishlists', [WishlistController::class, 'adminIndex']);
        Route::delete('/admin/wishlists/{id}', [WishlistController::class, 'adminDestroy']);
    });

});
