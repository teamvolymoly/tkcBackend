# TheKawaCompany API Documentation

## Base URL
- Local: `http://127.0.0.1:8000`
- API Prefix: `/api`

## Authentication
- Customer token: `Bearer {{token}}`
- Admin token: `Bearer {{admin_token}}`
- Token type: Laravel Sanctum

## Standard Response Shape
- Success:
```json
{
  "status": true,
  "message": "...",
  "data": {}
}
```
- Validation Error:
```json
{
  "status": false,
  "errors": {
    "field": ["error message"]
  }
}
```

## 1) Auth APIs
### POST `/api/auth/register`
Auth: Public  
Body:
```json
{
  "name": "Test Customer",
  "email": "customer@example.com",
  "phone": "9999999999",
  "password": "password",
  "password_confirmation": "password"
}
```

### POST `/api/auth/login`
Auth: Public  
Body:
```json
{
  "email": "customer@example.com",
  "password": "password"
}
```

### POST `/api/auth/logout`
Auth: Customer/Admin token

### POST `/api/auth/refresh`
Auth: Customer/Admin token

### GET `/api/auth/profile`
Auth: Customer/Admin token

### PUT `/api/auth/profile`
Auth: Customer/Admin token  
Body (any):
```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "8888888888"
}
```

### POST `/api/auth/change-password`
Auth: Customer/Admin token  
Body:
```json
{
  "current_password": "password",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

## 2) Address APIs
### POST `/api/addresses`
Auth: Customer/Admin token

### GET `/api/addresses`
Auth: Customer/Admin token

### GET `/api/addresses/{id}`
Auth: Customer/Admin token

### PUT `/api/addresses/{id}`
Auth: Customer/Admin token

### DELETE `/api/addresses/{id}`
Auth: Customer/Admin token

### POST `/api/addresses/{id}/set-default`
Auth: Customer/Admin token

Create/Update body example:
```json
{
  "address_line1": "221B Baker Street",
  "address_line2": "Near Market",
  "city": "Delhi",
  "state": "Delhi",
  "pincode": "110001",
  "country": "India",
  "is_default": true
}
```

## 3) Category APIs
### GET `/api/categories`
Auth: Public

### GET `/api/categories/{category}`
Auth: Public

### GET `/api/categories/{category}/subcategories`
Auth: Public

### POST `/api/categories`
Auth: Admin token

### PUT `/api/categories/{category}`
Auth: Admin token

### DELETE `/api/categories/{category}`
Auth: Admin token

Body example:
```json
{
  "name": "Green Tea",
  "description": "Healthy tea",
  "parent_id": null,
  "status": true
}
```

## 4) Product APIs
### GET `/api/products`
Auth: Public

### GET `/api/products/{slug}`
Auth: Public

### POST `/api/products`
Auth: Admin token

### PUT `/api/products/{id}`
Auth: Admin token

### DELETE `/api/products/{id}`
Auth: Admin token

Body example:
```json
{
  "category_id": 1,
  "subcategory_id": null,
  "name": "Chamomile Bliss Tea",
  "short_description": "Relaxing herbal tea",
  "allergic_information": "None",
  "tea_type": "Herbal",
  "disclaimer": "Consult physician if pregnant",
  "description": "Full product description",
  "ingredients": "Chamomile, Lemongrass",
  "features": [{"icon":"leaf","text":"Organic"}],
  "status": true
}
```

## 5) Product Variant APIs
### GET `/api/products/{id}/variants`
Auth: Public

### POST `/api/variants`
Auth: Admin token

### PUT `/api/variants/{id}`
Auth: Admin token

### DELETE `/api/variants/{id}`
Auth: Admin token

Body example:
```json
{
  "product_id": 1,
  "variant_name": "100g Pack",
  "sku": "CHAM-100G",
  "price": 399,
  "stock": 50,
  "weight": 0.1,
  "dimensions": "10x5x3",
  "net_weight": "100g",
  "tags": ["best-seller"],
  "brewing_rituals": [{"icon":"cup","text":"Brew 3 min"}],
  "status": true
}
```

## 6) Product Image APIs
### GET `/api/products/{id}/images`
Auth: Public

### POST `/api/product-images`
Auth: Admin token

### DELETE `/api/product-images/{id}`
Auth: Admin token

Body:
```json
{
  "product_id": 1,
  "image_url": "https://example.com/images/tea.png",
  "sort_order": 1
}
```

## 7) Ingredient APIs
### GET `/api/products/{id}/ingredients`
Auth: Public

### POST `/api/products/{id}/ingredients`
Auth: Admin token

### DELETE `/api/ingredients/{id}`
Auth: Admin token

Body:
```json
{
  "name": "Chamomile",
  "value": "50%",
  "sort_order": 1
}
```

## 8) Nutrition APIs
### GET `/api/products/{id}/nutrition`
Auth: Public

### POST `/api/products/{id}/nutrition`
Auth: Admin token

Body:
```json
{
  "nutrient": "Calories",
  "value": "5",
  "unit": "kcal"
}
```

## 9) Cart APIs
### GET `/api/cart`
Auth: Customer/Admin token

### POST `/api/cart`
Auth: Customer/Admin token

### PUT `/api/cart/{id}`
Auth: Customer/Admin token

### DELETE `/api/cart/{id}`
Auth: Customer/Admin token

### DELETE `/api/cart`
Auth: Customer/Admin token

Body examples:
```json
{
  "variant_id": 1,
  "quantity": 2
}
```

```json
{
  "quantity": 3
}
```

## 10) Wishlist APIs
### POST `/api/wishlist`
Auth: Customer/Admin token

### GET `/api/wishlist`
Auth: Customer/Admin token

### DELETE `/api/wishlist/{id}`
Auth: Customer/Admin token

Body:
```json
{
  "product_id": 1
}
```

## 11) Order APIs
### POST `/api/orders`
Auth: Customer/Admin token

### GET `/api/orders`
Auth: Customer/Admin token

### GET `/api/orders/{id}`
Auth: Customer/Admin token

### POST `/api/orders/{id}/cancel`
Auth: Customer/Admin token

### GET `/api/orders/{id}/track`
Auth: Customer/Admin token

Create body example:
```json
{
  "address_id": 1,
  "coupon_code": "WELCOME10",
  "shipping_method_code": "STANDARD",
  "notes": "Please deliver fast"
}
```

## 12) Payment APIs
### POST `/api/payments`
Auth: Customer/Admin token

### POST `/api/payments/webhook`
Auth: Public

### GET `/api/payments/{order_id}`
Auth: Customer/Admin token

Create payment body:
```json
{
  "order_id": 1,
  "payment_method": "razorpay",
  "transaction_id": "TXN123456",
  "status": "success",
  "gateway_payload": {"source": "postman"}
}
```

Webhook body:
```json
{
  "transaction_id": "TXN123456",
  "status": "success"
}
```

## 13) Coupon APIs
### GET `/api/coupons`
Auth: Public

### POST `/api/coupons/apply`
Auth: Customer/Admin token

Body:
```json
{
  "code": "WELCOME10",
  "amount": 1000
}
```

## 14) Review APIs
### POST `/api/reviews`
Auth: Customer/Admin token

### GET `/api/products/{id}/reviews`
Auth: Public

### DELETE `/api/reviews/{id}`
Auth: Customer/Admin token

Body:
```json
{
  "product_id": 1,
  "rating": 5,
  "review": "Great taste and aroma"
}
```

## 15) Inventory APIs
### GET `/api/inventory`
Auth: Admin token

### PUT `/api/inventory/{variant_id}`
Auth: Admin token

Body:
```json
{
  "stock": 70,
  "reserved_stock": 5,
  "warehouse": "WH-01"
}
```

## 16) Admin APIs
### GET `/api/admin/dashboard`
Auth: Admin token

### GET `/api/admin/customers`
Auth: Admin token

### GET `/api/admin/orders`
Auth: Admin token

### PUT `/api/admin/orders/{id}/status`
Auth: Admin token

Body:
```json
{
  "status": "processing"
}
```

## 17) Shipping APIs
### GET `/api/shipping/methods`
Auth: Public

### POST `/api/shipping/calculate`
Auth: Public

Body:
```json
{
  "method_code": "STANDARD",
  "weight": 0.5,
  "amount": 1000
}
```

## 18) Search API
### GET `/api/search?q=tea`
Auth: Public

## Quick Testing Order
1. Register
2. Login (Customer + Admin)
3. Create Category (Admin)
4. Create Product (Admin)
5. Create Variant (Admin)
6. Create Address (Customer)
7. Add to Cart (Customer)
8. Create Order (Customer)
9. Create Payment (Customer)
10. Track/Review/Search
