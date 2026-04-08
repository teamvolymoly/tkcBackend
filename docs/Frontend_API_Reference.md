# The Kawa Company Frontend API Reference

Updated on: 08 Apr 2026

This document is for the frontend team. It covers the customer-facing APIs currently available in the backend, including request payloads, auth requirements, common response structure, and the latest product detail response shape.

## Base URLs

- Production API: `https://tkc.volymoly.com/api`
- Local API: `http://localhost/theKawaCompany/public/api`
- Production media URL pattern: `https://tkc.volymoly.com/media/public/{path}`
- Local media URL pattern: `http://localhost/theKawaCompany/public/media/public/{path}`

## Auth Header

Use Sanctum bearer token after login/register:

```http
Authorization: Bearer {token}
Accept: application/json
```

## Common Response Format

Most endpoints return this format:

```json
{
  "status": true,
  "message": "Success message",
  "data": {}
}
```

Validation errors usually return:

```json
{
  "status": false,
  "errors": {
    "field_name": [
      "The field is required."
    ]
  }
}
```

Some business-rule failures return:

```json
{
  "status": false,
  "message": "Readable error message"
}
```

## Image Handling

- Use `*_url` fields for frontend rendering.
- Do not build `/storage/...` URLs manually.
- Current backend serves images through `/media/public/{path}`.
- Example image URL:

```text
https://tkc.volymoly.com/media/public/hero-sections/DMiYa5pVZThjTo8K1ZieXsXKXVY9wmYWoJF3cZRx.jpg
```

## Public APIs

### 1. Register

- Method: `POST`
- URL: `/auth/register`
- Auth: No

Payload:

```json
{
  "name": "Demo User",
  "email": "demo@example.com",
  "phone": "9876543210",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

Success response:

```json
{
  "status": true,
  "message": "Registered successfully",
  "token": "1|sanctum_token_here",
  "user": {
    "id": 12,
    "name": "Demo User",
    "email": "demo@example.com",
    "phone": "9876543210"
  }
}
```

### 2. Login

- Method: `POST`
- URL: `/auth/login`
- Auth: No

Payload:

```json
{
  "email": "demo@example.com",
  "password": "secret123"
}
```

### 3. Home Hero Sections

- Method: `GET`
- URL: `/home/hero-sections`
- Auth: No

Sample response:

```json
{
  "status": true,
  "message": "Home hero sections fetched successfully",
  "data": [
    {
      "id": 1,
      "product_name": "Hibiscus Kahwa",
      "product_slug": "hibiscus-kahwa",
      "product_image_path": "hero-sections/DMiYa5pVZThjTo8K1ZieXsXKXVY9wmYWoJF3cZRx.jpg",
      "product_image_url": "https://tkc.volymoly.com/media/public/hero-sections/DMiYa5pVZThjTo8K1ZieXsXKXVY9wmYWoJF3cZRx.jpg",
      "status": true,
      "sort_order": 1,
      "created_at": "2026-04-08T08:46:00.000000Z",
      "updated_at": "2026-04-08T08:46:00.000000Z"
    }
  ]
}
```

### 4. Home Bestselling Products

- Method: `GET`
- URL: `/home/bestselling-products`
- Auth: No

Each item includes:

- `id`
- `name`
- `slug`
- `short_description`
- `status`
- `category`
- `subcategory`
- `default_variant`
- `sold_quantity`

### 5. Home Shop By Category

- Method: `GET`
- URL: `/home/shop-by-category`
- Auth: No

Each item includes:

- `id`
- `slug`
- `img`
- `name`
- `description`
- `sold_quantity`

### 6. Home Blogs

- Method: `GET`
- URL: `/home/blogs`
- Auth: No

Each item includes:

- `id`
- `title`
- `slug`
- `excerpt`
- `content`
- `featured_image_path`
- `featured_image_url`
- `published_at`
- `created_at`
- `updated_at`

### 7. Categories

- Method: `GET`
- URL: `/categories`
- Auth: No

Returns parent categories with nested `children`.

Each category includes:

- `id`
- `name`
- `slug`
- `description`
- `image_path`
- `image_url`
- `parent_id`
- `status`
- `children`

### 8. Category Detail

- Method: `GET`
- URL: `/categories/{category}`
- Auth: No

Example:

```text
GET /api/categories/1
```

Note:

- Route param is category ID because Laravel route model binding is used here.

### 9. Category Subcategories

- Method: `GET`
- URL: `/categories/{category}/subcategories`
- Auth: No

### 10. Product Listing

- Method: `GET`
- URL: `/products`
- Auth: No

Query params:

- `category_id` optional
- `q` optional search text
- `status` optional, mostly useful for admin/testing

Example:

```text
GET /api/products?category_id=1&q=kahwa
```

Returns paginated data:

```json
{
  "status": true,
  "message": "Products fetched successfully",
  "data": {
    "current_page": 1,
    "data": [],
    "last_page": 1,
    "per_page": 20,
    "total": 4
  }
}
```

Each product card usually includes:

- `id`
- `name`
- `slug`
- `short_description`
- `category`
- `subcategory`
- `default_variant`
- `variants`

### 11. Product Detail

- Method: `GET`
- URL: `/products/{slug}`
- Auth: No

Example:

```text
GET /api/products/hibiscus-kahwa
```

Current response shape:

```json
{
  "status": true,
  "message": "Product fetched successfully",
  "data": {
    "id": 7,
    "name": "Hibiscus Kahwa",
    "slug": "hibiscus-kahwa",
    "short_description": "A delightful blend to brighten your day.",
    "description": "Full product description here",
    "allergic_information": "Contains almonds",
    "tea_type": "With almonds & cardamom",
    "disclaimer": "Natural product disclaimer",
    "features": [
      "Premium herbal tea",
      "Caffeine free"
    ],
    "category": {
      "id": 1,
      "name": "Shop"
    },
    "subcategory": null,
    "breadcrumbs": [
      {
        "label": "Home",
        "value": "home"
      },
      {
        "label": "Shop",
        "value": "shop"
      },
      {
        "label": "Hibiscus Kahwa",
        "value": "hibiscus-kahwa"
      }
    ],
    "gallery": [
      {
        "id": 21,
        "image_path": "products/variants/demo.jpg",
        "image_url": "https://tkc.volymoly.com/media/public/products/variants/demo.jpg",
        "is_primary": true,
        "sort_order": 0
      }
    ],
    "default_variant_id": 14,
    "price": 525,
    "compare_price": 649,
    "currency": "INR",
    "variants": [
      {
        "id": 14,
        "variant_name": "100g",
        "size": "100g",
        "color": null,
        "sku": "HIB-100",
        "price": 525,
        "formatted_price": "525.00",
        "compare_price": 649,
        "formatted_compare_price": "649.00",
        "stock": 40,
        "weight": "100",
        "dimensions": null,
        "net_weight": "100g",
        "tags": [
          "50 cups"
        ],
        "brewing_rituals": [
          {
            "group": "Hot Brew",
            "title": "Water",
            "icon": "cup",
            "text": "200ml",
            "value": "200ml"
          }
        ],
        "is_default": true,
        "status": true,
        "primary_image": {
          "id": 21,
          "image_url": "https://tkc.volymoly.com/media/public/products/variants/demo.jpg",
          "image_path": "products/variants/demo.jpg"
        },
        "images": [
          {
            "id": 21,
            "image_url": "https://tkc.volymoly.com/media/public/products/variants/demo.jpg",
            "image_path": "products/variants/demo.jpg",
            "is_primary": true,
            "sort_order": 0
          }
        ]
      }
    ],
    "default_variant": {},
    "defaultVariant": {},
    "selected_variant": {},
    "brewing_rituals": [
      {
        "group": "Hot Brew",
        "title": "Water",
        "icon": "cup",
        "text": "200ml",
        "value": "200ml"
      },
      {
        "group": "Iced Brew",
        "title": "Serve",
        "icon": "glass",
        "text": "Refrigerate and add ice",
        "value": "Serve chilled"
      }
    ],
    "ingredients": [
      {
        "id": 1,
        "name": "Chamomile Flower",
        "value": "Chamomile Flower",
        "image_path": "products/ingredients/chamomile.jpg",
        "image_url": "https://tkc.volymoly.com/media/public/products/ingredients/chamomile.jpg",
        "sort_order": 0
      }
    ],
    "ingredients_text": "Chamomile Flower, Green Tea, Lemongrass",
    "ingredients_list": [
      {
        "id": 1,
        "name": "Chamomile Flower",
        "value": "Chamomile Flower",
        "image_path": "products/ingredients/chamomile.jpg",
        "image_url": "https://tkc.volymoly.com/media/public/products/ingredients/chamomile.jpg",
        "sort_order": 0
      }
    ],
    "nutrition": [
      {
        "id": 1,
        "nutrient": "Energy",
        "value": "12",
        "unit": "kcal"
      }
    ],
    "reviews": {
      "average_rating": 5,
      "count": 5,
      "items": [
        {
          "id": 9,
          "rating": 5,
          "review": "Loved it",
          "created_at": "2026-04-08T10:30:00.000000Z",
          "user": {
            "id": 3,
            "name": "Demo User",
            "email": "demo@example.com"
          }
        }
      ]
    },
    "discover_more": [
      {
        "id": 3,
        "name": "Mint Kahwa",
        "slug": "mint-kahwa",
        "short_description": "Refreshing blend",
        "category": {
          "id": 1,
          "name": "Shop"
        },
        "subcategory": null,
        "default_variant": {},
        "price": 450,
        "compare_price": 500,
        "image_url": "https://tkc.volymoly.com/media/public/products/variants/mint.jpg"
      }
    ],
    "discoverMore": [
      {
        "id": 3,
        "name": "Mint Kahwa",
        "slug": "mint-kahwa",
        "short_description": "Refreshing blend"
      }
    ]
  }
}
```

Important frontend notes:

- `discover_more` excludes the currently opened product.
- `discoverMore` is also returned for camelCase compatibility.
- Use `compare_price` for strike price or MRP display.
- Use `ingredients` or `ingredients_list` for ingredient cards with image.
- Use `brewing_rituals` for hot brew and iced brew sections.

### 12. Product Variants By Product ID

- Method: `GET`
- URL: `/products/{id}/variants`
- Auth: No

Example:

```text
GET /api/products/7/variants
```

### 13. Variant Images

- Method: `GET`
- URL: `/variants/{id}/images`
- Auth: No

Example:

```text
GET /api/variants/14/images
```

### 14. Product Ingredients

- Method: `GET`
- URL: `/products/{id}/ingredients`
- Auth: No

Each item includes:

- `id`
- `product_id`
- `name`
- `value`
- `image_path`
- `image_url`
- `sort_order`

### 15. Product Nutrition

- Method: `GET`
- URL: `/products/{id}/nutrition`
- Auth: No

Each item includes:

- `id`
- `product_id`
- `nutrient`
- `value`
- `unit`

### 16. Product Reviews

- Method: `GET`
- URL: `/products/{id}/reviews`
- Auth: No

Each review includes:

- `id`
- `product_id`
- `user_id`
- `rating`
- `review`
- `created_at`
- `user`

### 17. Search

- Method: `GET`
- URL: `/search`
- Auth: No

Query params:

- `q` required

Example:

```text
GET /api/search?q=hibiscus
```

### 18. Coupons List

- Method: `GET`
- URL: `/coupons`
- Auth: No

Returns active and non-expired coupons.

### 19. Blog Posts List

- Method: `GET`
- URL: `/blog-posts`
- Auth: No

Query params:

- `q` optional

Returns paginated blog posts.

### 20. Blog Post Detail

- Method: `GET`
- URL: `/blog-posts/{blogPost}`
- Auth: No

Example:

```text
GET /api/blog-posts/1
```

Note:

- Route param is blog post ID because Laravel route model binding is used here.

## Authenticated Customer APIs

All endpoints below require:

```http
Authorization: Bearer {token}
```

### 21. Logout

- Method: `POST`
- URL: `/auth/logout`

### 22. Refresh Token

- Method: `POST`
- URL: `/auth/refresh`

### 23. Get Profile

- Method: `GET`
- URL: `/auth/profile`

Customer profile data includes fields such as:

- `id`
- `name`
- `email`
- `phone`
- `created_at`


### 24. Update Profile

- Method: `PUT`
- URL: `/auth/profile`

Payload:

```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "9999999999"
}
```

### 25. Change Password

- Method: `POST`
- URL: `/auth/change-password`

Payload:

```json
{
  "current_password": "old123456",
  "password": "new123456",
  "password_confirmation": "new123456"
}
```

## Address APIs

### 26. Create Address

- Method: `POST`
- URL: `/addresses`

Payload:

```json
{
  "address_line1": "123 Green Avenue",
  "address_line2": "Near City Mall",
  "city": "Delhi",
  "state": "Delhi",
  "pincode": "110001",
  "country": "India",
  "is_default": true
}
```

### 27. Address List

- Method: `GET`
- URL: `/addresses`

### 28. Address Detail

- Method: `GET`
- URL: `/addresses/{id}`

### 29. Update Address

- Method: `PUT`
- URL: `/addresses/{id}`

Payload:

```json
{
  "address_line1": "456 New Address",
  "city": "Noida",
  "state": "Uttar Pradesh",
  "pincode": "201301",
  "country": "India",
  "is_default": false
}
```

### 30. Delete Address

- Method: `DELETE`
- URL: `/addresses/{id}`

### 31. Set Default Address

- Method: `POST`
- URL: `/addresses/{id}/set-default`

## Cart APIs

### 32. Get Cart

- Method: `GET`
- URL: `/cart`

### 33. Add To Cart

- Method: `POST`
- URL: `/cart`

Payload:

```json
{
  "variant_id": 14,
  "quantity": 1
}
```

### 34. Update Cart Item

- Method: `PUT`
- URL: `/cart/{id}`

Payload:

```json
{
  "quantity": 2
}
```

### 35. Remove Cart Item

- Method: `DELETE`
- URL: `/cart/{id}`

### 36. Clear Cart

- Method: `DELETE`
- URL: `/cart`

Cart item relation data includes:

- `variant`
- `variant.product`
- `variant.primaryImage`
- `variant.inventory`

## Wishlist APIs

### 37. Add To Wishlist

- Method: `POST`
- URL: `/wishlist`

Payload:

```json
{
  "product_id": 7
}
```

### 38. Wishlist List

- Method: `GET`
- URL: `/wishlist`

### 39. Remove Wishlist Item

- Method: `DELETE`
- URL: `/wishlist/{id}`

Wishlist item relation data includes:

- `product`
- `product.defaultVariant`
- `product.defaultVariant.primaryImage`

## Order APIs

### 40. Create Order

- Method: `POST`
- URL: `/orders`

Payload:

```json
{
  "address_id": 3,
  "coupon_code": "WELCOME10",
  "notes": "Please deliver in evening"
}
```

Response order fields include:

- `id`
- `order_number`
- `subtotal`
- `discount_amount`
- `shipping_amount`
- `total_amount`
- `coupon_code`
- `status`
- `payment_status`
- `notes`
- `items`
- `address`

### 41. Orders List

- Method: `GET`
- URL: `/orders`

Returns paginated orders.

### 42. Order Detail

- Method: `GET`
- URL: `/orders/{id}`

### 43. Cancel Order

- Method: `POST`
- URL: `/orders/{id}/cancel`

### 44. Track Order

- Method: `GET`
- URL: `/orders/{id}/track`

Sample response:

```json
{
  "status": true,
  "data": {
    "order_id": 10,
    "order_number": "ORD-20260408123055-4821",
    "status": "confirmed",
    "payment_status": "paid",
    "updated_at": "2026-04-08T12:31:10.000000Z"
  }
}
```

## Payment APIs

### 45. Create Payment Record

- Method: `POST`
- URL: `/payments`

Payload:

```json
{
  "order_id": 10,
  "payment_method": "razorpay",
  "transaction_id": "pay_123456789",
  "status": "success",
  "gateway_payload": {
    "gateway": "razorpay",
    "signature_verified": true
  }
}
```

Allowed `status` values:

- `initiated`
- `success`
- `failed`
- `refunded`

### 46. Payment History By Order

- Method: `GET`
- URL: `/payments/{order_id}`

### 47. Payment Webhook

- Method: `POST`
- URL: `/payments/webhook`
- Auth: No
- Note: server-to-server endpoint, not for frontend app use

Webhook payload example:

```json
{
  "transaction_id": "pay_123456789",
  "status": "success"
}
```

## Coupon APIs

### 48. Apply Coupon

- Method: `POST`
- URL: `/coupons/apply`

Payload:

```json
{
  "code": "WELCOME10",
  "amount": 525
}
```

Sample response:

```json
{
  "status": true,
  "data": {
    "coupon": {
      "id": 1,
      "code": "WELCOME10",
      "discount_type": "percent",
      "discount_value": 10
    },
    "discount": 52.5,
    "final_amount": 472.5
  }
}
```

## Review APIs

### 49. Save Review

- Method: `POST`
- URL: `/reviews`

Payload:

```json
{
  "product_id": 7,
  "rating": 5,
  "review": "Loved the flavor and aroma."
}
```

Note:

- Same user reviewing same product again updates the existing review.

### 50. Delete Review

- Method: `DELETE`
- URL: `/reviews/{id}`

## Quick Frontend Mapping

For home page:

- Banner slider: `/home/hero-sections`
- Bestseller section: `/home/bestselling-products`
- Shop by category section: `/home/shop-by-category`
- Blog section: `/home/blogs`

For shop page:

- Category list: `/categories`
- Product list: `/products`
- Search: `/search?q=...`

For product detail page:

- Main detail: `/products/{slug}`
- Variant fallback: `/products/{id}/variants`
- Extra ingredient list: `/products/{id}/ingredients`
- Nutrition table: `/products/{id}/nutrition`
- Review list: `/products/{id}/reviews`

For account and checkout:

- Profile: `/auth/profile`
- Addresses: `/addresses`
- Cart: `/cart`
- Wishlist: `/wishlist`
- Orders: `/orders`
- Payments: `/payments`
- Coupon apply: `/coupons/apply`

## Recommended Frontend Rules

- Always render product and category images using returned `*_url` fields.
- Prefer `/products/{slug}` for product detail page because it already includes variants, gallery, ingredients, nutrition, reviews, and discover more.
- Use `discover_more` from product detail response for the "Discover More" section.
- Use `compare_price` for struck-through old price when available.
- Use `default_variant` as the initial selected variant on product cards and product detail.
- Expect pagination on `/products`, `/orders`, and `/blog-posts`.
