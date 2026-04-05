# TheKawaCompany API Audit + Future Plan

## 1) Current Status
- Total API routes: 66
- Core modules implemented: Auth, Address, Category, Product, Variant, Images, Ingredients, Nutrition, Cart, Wishlist, Order, Payment, Coupon, Review, Inventory, Admin, Shipping, Search.
- Migrations: all ran successfully.

## 2) Health Check Result
System is runnable, but production-grade readiness ke liye niche ke issues fix karne recommended hain.

## 3) Key Issues Found

### High Priority
1. Payment webhook security hardening required
- Endpoint public hai; signature verification layer add karni chahiye.
- Risk: payment status spoof/update.

2. Order address ownership validation needed
- `address_id` exists check hai, but ownership check (same user) enforce karna chahiye.
- Risk: cross-user address misuse.

3. Stock reservation/deduction flow incomplete at order placement
- Order create ke waqt stock movement explicit nahi hai.
- Risk: overselling.

### Medium Priority
4. Inventory update endpoint should validate variant existence before upsert.

### Low Priority
5. API feature tests are minimal; ecommerce flows ke tests required.

## 4) What APIs Are Still Needed (Best Ecommerce Standard)

### Phase 1 (Business Critical)
- Refund APIs
  - `POST /api/orders/{id}/return-request`
  - `POST /api/payments/{id}/refund`
  - `GET /api/refunds/{id}`
- Payment verification APIs
  - `POST /api/payments/{id}/verify`
  - `GET /api/payments/{id}/status`
- Inventory movement APIs
  - `POST /api/inventory/reserve`
  - `POST /api/inventory/release`
  - `POST /api/inventory/deduct`

### Phase 2 (Operational)
- Invoice APIs
  - `GET /api/orders/{id}/invoice`
  - `POST /api/orders/{id}/invoice/regenerate`
- Coupon Admin CRUD
  - `POST/GET/PUT/DELETE /api/admin/coupons`
- Shipping Method Admin CRUD
  - `POST/GET/PUT/DELETE /api/admin/shipping-methods`

### Phase 3 (Growth)
- Analytics APIs
  - `GET /api/admin/analytics/revenue`
  - `GET /api/admin/analytics/top-products`
- Review moderation APIs
  - `GET /api/admin/reviews`
  - `PUT /api/admin/reviews/{id}/approve`
- Search enhancements
  - `GET /api/search/suggestions`
  - `POST /api/search/faceted`

### Phase 4 (Scale)
- Multi-warehouse APIs
- Tax/GST APIs
- Vendor/Seller APIs (if marketplace model)

## 5) Recommended Build Order
1. Payment security + refund flow
2. Inventory reservation/deduction
3. Invoice + coupon/shipping admin CRUD
4. Fulfillment/operations APIs
5. Analytics + moderation + advanced search

## 6) Client Summary (Ready-to-Say)
- Backend core ecommerce APIs live and functional hain.
- Next sprint ka focus reliability and operations pe hona chahiye (payment integrity, stock safety, refunds).
- Uske baad growth APIs (analytics/search/SEO) add karna best rahega.
