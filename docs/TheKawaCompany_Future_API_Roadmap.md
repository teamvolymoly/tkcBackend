# TheKawaCompany - Future E-Commerce API Roadmap (No Code Changes)

## Purpose
Yeh document clear karta hai:
1. Abhi project me kaun-kaun APIs available hain.
2. Production-grade ecommerce ke liye kaun si APIs abhi pending hain.
3. Future roadmap kis priority order me execute karna best rahega.

## Current API Coverage (Implemented)
Source routes: `routes/api.php` (66 routes)

### Implemented Modules
- Auth
  - register, login, logout, refresh, profile, update profile, change password
- User Address
  - CRUD + set-default
- Category/Subcategory
  - list, detail, subcategories, admin create/update/delete
- Product Catalog
  - list, slug detail, admin create/update/delete
- Product Variants
  - list, admin create/update/delete
- Product Images
  - list, admin add/delete
- Ingredients
  - list, admin add/delete
- Nutrition
  - list, admin add
- Cart
  - get/add/update/delete/clear
- Wishlist
  - add/list/delete
- Orders
  - create/list/show/cancel/track
- Payments
  - create, webhook, list by order
- Coupons
  - list/apply
- Reviews
  - add/list/delete
- Inventory
  - admin list/update
- Admin
  - dashboard/customers/orders/order-status-update
- Shipping
  - methods/calculate
- Search
  - product keyword search

## Gap Analysis: APIs Still Needed for Best-Standard E-Commerce

## Phase 1 (Business-Critical) - Must Have

### 1. Payment Security + Gateway Integrity APIs
Current gap:
- webhook endpoint is open and does not include gateway signature verification layer.

Recommended APIs:
- `POST /api/payments/webhook/{gateway}`
- `POST /api/payments/{payment_id}/verify`
- `GET /api/payments/{payment_id}/status`

Why:
- Fraud prevention, payment-state consistency, reconciliation safety.

### 2. Refund & Return APIs
Current gap:
- dedicated refund and return workflows missing.

Recommended APIs:
- `POST /api/orders/{id}/return-request`
- `GET /api/orders/{id}/return-status`
- `POST /api/payments/{id}/refund`
- `GET /api/refunds/{id}`
- `GET /api/admin/refunds`
- `PUT /api/admin/refunds/{id}/approve`

Why:
- Core ecommerce lifecycle incomplete without returns/refunds.

### 3. Inventory Reservation & Stock Movement APIs
Current gap:
- stock deduction/reservation lifecycle endpoints not explicit.

Recommended APIs:
- `POST /api/inventory/reserve`
- `POST /api/inventory/release`
- `POST /api/inventory/deduct`
- `GET /api/admin/inventory/movements`

Why:
- Prevent overselling and improve auditability.

### 4. Order Fulfillment APIs
Current gap:
- shipment and package-level management missing.

Recommended APIs:
- `POST /api/admin/orders/{id}/pack`
- `POST /api/admin/orders/{id}/ship`
- `POST /api/admin/orders/{id}/deliver`
- `POST /api/admin/orders/{id}/failed-delivery`

Why:
- Real operations need fulfillment states beyond generic status update.

## Phase 2 (High Value) - Strongly Recommended

### 5. Invoice APIs
Current gap:
- invoice generation/download endpoints missing.

Recommended APIs:
- `GET /api/orders/{id}/invoice`
- `POST /api/orders/{id}/invoice/regenerate`
- `GET /api/admin/invoices`

Why:
- B2C/B2B compliance, accounting and customer support.

### 6. Coupon Admin Management APIs
Current gap:
- only coupon list/apply is available.

Recommended APIs:
- `POST /api/admin/coupons`
- `GET /api/admin/coupons`
- `GET /api/admin/coupons/{id}`
- `PUT /api/admin/coupons/{id}`
- `DELETE /api/admin/coupons/{id}`
- `PUT /api/admin/coupons/{id}/toggle`

Why:
- Marketing team ko campaign control chahiye.

### 7. Shipping Method Admin APIs
Current gap:
- shipping methods create/update/delete not available.

Recommended APIs:
- `POST /api/admin/shipping-methods`
- `GET /api/admin/shipping-methods`
- `PUT /api/admin/shipping-methods/{id}`
- `DELETE /api/admin/shipping-methods/{id}`

Why:
- Logistics pricing dynamic hoti hai; admin manage kar ???.

### 8. Customer Account Management APIs (Admin)
Current gap:
- customer detail lifecycle limited.

Recommended APIs:
- `GET /api/admin/customers/{id}`
- `PUT /api/admin/customers/{id}/status`
- `GET /api/admin/customers/{id}/orders`
- `GET /api/admin/customers/{id}/addresses`

Why:
- Support and fraud/risk handling needs deeper customer view.

## Phase 3 (Scale/Advanced) - Future Best

### 9. Product Merchandising APIs
Recommended APIs:
- `POST /api/admin/products/{id}/publish`
- `POST /api/admin/products/{id}/unpublish`
- `POST /api/admin/products/{id}/feature`
- `PUT /api/admin/products/{id}/sort-order`

Why:
- catalog curation and conversion optimization.

### 10. SEO APIs
Recommended APIs:
- `PUT /api/admin/products/{id}/seo`
- `PUT /api/admin/categories/{id}/seo`
- `GET /api/sitemap/products`

Why:
- organic traffic scaling.

### 11. Analytics APIs
Recommended APIs:
- `GET /api/admin/analytics/revenue`
- `GET /api/admin/analytics/orders`
- `GET /api/admin/analytics/customers`
- `GET /api/admin/analytics/conversion`
- `GET /api/admin/analytics/top-products`

Why:
- decision-making and growth tracking.

### 12. Notification APIs
Recommended APIs:
- `POST /api/notifications/test`
- `GET /api/notifications`
- `PUT /api/notifications/{id}/read`
- `POST /api/admin/orders/{id}/resend-email`

Why:
- order communication and customer trust.

### 13. Wishlist Enhancements
Recommended APIs:
- `POST /api/wishlist/{id}/move-to-cart`
- `POST /api/wishlist/share`

Why:
- customer engagement and retention.

### 14. Review Moderation APIs
Recommended APIs:
- `GET /api/admin/reviews`
- `PUT /api/admin/reviews/{id}/approve`
- `PUT /api/admin/reviews/{id}/reject`

Why:
- content quality and abuse control.

### 15. Search & Filter Advanced APIs
Recommended APIs:
- `GET /api/search/suggestions?q=`
- `GET /api/products/filters`
- `POST /api/search/faceted`

Why:
- better discovery and conversion.

## Phase 4 (Enterprise Grade)

### 16. Multi-Warehouse APIs
Recommended APIs:
- `POST /api/admin/warehouses`
- `GET /api/admin/warehouses`
- `PUT /api/admin/warehouses/{id}`
- `POST /api/admin/inventory/transfer`

### 17. Tax/GST APIs
Recommended APIs:
- `POST /api/tax/calculate`
- `GET /api/admin/tax-rules`
- `PUT /api/admin/tax-rules/{id}`

### 18. Seller/Vendor APIs (if marketplace expansion)
Recommended APIs:
- `POST /api/admin/vendors`
- `GET /api/admin/vendors`
- `GET /api/vendor/orders`
- `PUT /api/vendor/orders/{id}/status`

## Non-Functional API Needs (Critical)

### 1. API Versioning
- Introduce `/api/v1/...` (and future `/v2`).

### 2. Idempotency
- For payment/order creation APIs add idempotency keys.

### 3. Rate Limiting
- public/search/auth endpoints par stricter throttling.

### 4. Audit Logs
- admin actions ke liye audit endpoints:
  - `GET /api/admin/audit-logs`

### 5. Health/Readiness APIs
- `GET /api/health`
- `GET /api/ready`

## Suggested Build Order (Recommended)
1. Payment security + refunds/returns
2. Inventory reservation/deduction movement APIs
3. Invoice + coupon/shipping admin CRUD
4. Fulfillment APIs
5. Analytics + notifications + review moderation
6. Multi-warehouse + tax + vendor (if needed)

## Summary for Client Communication
- Current backend covers core shopping journey end-to-end.
- Next priority should focus on reliability and operations:
  - payment integrity,
  - returns/refunds,
  - inventory correctness,
  - fulfillment traceability.
- After that, growth-focused APIs:
  - analytics,
  - SEO,
  - merchandising,
  - advanced search.

---
Document generated without changing business code/API logic; this is roadmap-only analysis.
