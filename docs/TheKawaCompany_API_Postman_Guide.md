# TheKawaCompany API - Step by Step Postman Guide

## 1) Import Files
1. Import collection: `TheKawaCompany_Ecommerce_API.postman_collection.json`
2. Import environment: `TheKawaCompany_Local.postman_environment.json`
3. Select environment: **TheKawaCompany Local**

## 2) Base URL
- Default: `http://127.0.0.1:8000`
- If using XAMPP public path: update `base_url` in environment.

## 3) Run Sequence (Recommended)
1. `Auth -> Register`
2. `Auth -> Login (Customer)`
3. `Auth -> Login (Admin)`
4. `Category -> Create Category (Admin)`
5. `Product -> Create Product (Admin)`
6. `Product Variant -> Create Variant (Admin)`
7. `Product Image -> Add Product Image (Admin)`
8. `Address -> Create Address`
9. `Cart -> Add to Cart`
10. `Order -> Create Order`
11. `Payment -> Create Payment`
12. `Order -> Track Order`

## 4) Token Handling
- `Login (Customer)` automatically saves token to `{{token}}`
- `Login (Admin)` automatically saves token to `{{admin_token}}`

## 5) Variable Mapping
Update these variables from your DB results:
- `category`
- `product_id`
- `product_slug`
- `variant_id`
- `address_id`
- `cart_item_id`
- `order_id`
- `review_id`
- `image_id`
- `ingredient_id`
- `wishlist_id`

## 6) API Modules Included
- Auth
- Address
- Category/Subcategory
- Product
- Product Variant
- Product Image
- Ingredient
- Nutrition
- Cart
- Wishlist
- Order
- Payment (including webhook)
- Coupon
- Review
- Inventory (Admin)
- Admin Dashboard/Customers/Orders
- Shipping
- Search

## 7) Notes
- Admin endpoints use `{{admin_token}}`.
- Customer endpoints use `{{token}}`.
- Public endpoints can run without token.
