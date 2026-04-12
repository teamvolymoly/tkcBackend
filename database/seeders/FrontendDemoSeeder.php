<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\HeroSection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('Seeding frontend demo data...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ([
            CouponUsage::class,
            Payment::class,
            OrderItem::class,
            Order::class,
            Wishlist::class,
            CartItem::class,
            Cart::class,
            UserAddress::class,
            Review::class,
            ProductVariant::class,
            Product::class,
            HeroSection::class,
            BlogPost::class,
            Coupon::class,
            Category::class,
        ] as $modelClass) {
            $modelClass::query()->delete();
        }

        User::query()
            ->whereNotIn('email', ['admin@example.com', 'test@example.com'])
            ->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $demoImage = static fn (string $seed, int $width = 1200, int $height = 1200) => "https://picsum.photos/seed/{$seed}/{$width}/{$height}";

        $categories = collect([
            'Kahwa Blends',
            'Herbal Tea',
            'Green Tea',
            'Black Tea',
            'Wellness Tea',
        ])->map(function (string $name, int $index) use ($demoImage) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Demo category {$name}.",
                'image_path' => $demoImage('category-'.$index, 900, 900),
                'status' => true,
            ]);
        });

        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '8888888888',
                'password' => Hash::make('password'),
            ]
        );
        $testUser->syncRoles(['customer']);

        $customers = collect([$testUser]);

        foreach (range(1, 5) as $index) {
            $user = User::updateOrCreate(
                ['email' => "customer{$index}@example.com"],
                [
                    'name' => "Customer {$index}",
                    'phone' => '9000000'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password'),
                ]
            );
            $user->syncRoles(['customer']);
            $customers->push($user);
        }

        $products = collect();
        $variants = collect();

        foreach ([
            'Hibiscus Kahwa',
            'Mint Kahwa',
            'Chamomile Tea',
            'Detox Green Tea',
            'Saffron Elixir',
        ] as $index => $name) {
            $product = Product::create([
                'category_id' => $categories[$index]->id,
                'slug' => Str::slug($name),
                'tag_line_1' => 'Daily Wellness',
                'name' => $name,
                'tag_line_2' => 'Pure botanical ritual',
                'description' => "{$name} is demo content for the simplified 2-table product module.",
                'image_1' => $demoImage('product-'.$index.'-1'),
                'image_2' => $demoImage('product-'.$index.'-2'),
                'image_3' => $demoImage('product-'.$index.'-3'),
                'image_4' => $demoImage('product-'.$index.'-4'),
                'image_5' => $demoImage('product-'.$index.'-5'),
                'ingredients' => [
                    ['name' => 'Tulsi', 'image' => $demoImage('ingredient-'.$index.'-1', 600, 600)],
                    ['name' => 'Ginger', 'image' => $demoImage('ingredient-'.$index.'-2', 600, 600)],
                    ['name' => 'Lemongrass', 'image' => $demoImage('ingredient-'.$index.'-3', 600, 600)],
                ],
                'faqs' => [
                    ['question' => 'How to brew?', 'answer' => 'Use one teaspoon in hot water for 3-5 minutes.'],
                    ['question' => 'When should I drink it?', 'answer' => 'Any time of the day.'],
                ],
                'status' => true,
            ]);

            foreach ([
                ['name' => '100g Pack', 'price' => 399 + ($index * 20), 'discount_price' => 349 + ($index * 20), 'weight' => '100g', 'is_default' => true],
                ['name' => '250g Pack', 'price' => 699 + ($index * 20), 'discount_price' => 629 + ($index * 20), 'weight' => '250g', 'is_default' => false],
            ] as $variantIndex => $variantSeed) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variantSeed['name'],
                    'sku' => 'TKC-'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'-'.($variantIndex + 1),
                    'price' => $variantSeed['price'],
                    'discount_price' => $variantSeed['discount_price'],
                    'weight' => $variantSeed['weight'],
                    'brewing_rituals' => [
                        ['ritual' => 'Boil 200ml water', 'image' => $demoImage('ritual-'.$index.'-'.$variantIndex.'-1', 500, 500)],
                        ['ritual' => 'Steep for 3-5 minutes', 'image' => $demoImage('ritual-'.$index.'-'.$variantIndex.'-2', 500, 500)],
                    ],
                    'is_default' => $variantSeed['is_default'],
                    'status' => true,
                ]);

                $variants->push($variant);
            }

            $products->push($product);
        }

        foreach ($customers as $customerIndex => $customer) {
            UserAddress::create([
                'user_id' => $customer->id,
                'address_line1' => ($customerIndex + 10).' Demo Street',
                'address_line2' => 'Near Sample Market',
                'city' => ['Delhi', 'Noida', 'Gurugram', 'Jaipur', 'Mumbai'][$customerIndex % 5],
                'state' => ['Delhi', 'Uttar Pradesh', 'Haryana', 'Rajasthan', 'Maharashtra'][$customerIndex % 5],
                'pincode' => '1100'.str_pad((string) ($customerIndex + 1), 2, '0', STR_PAD_LEFT),
                'country' => 'India',
                'is_default' => true,
            ]);
        }

        foreach (range(1, 5) as $index) {
            $customer = $customers[($index - 1) % $customers->count()];
            $cart = Cart::firstOrCreate(['user_id' => $customer->id]);

            CartItem::create([
                'cart_id' => $cart->id,
                'variant_id' => $variants[($index - 1) % $variants->count()]->id,
                'quantity' => 1 + ($index % 2),
            ]);

            Wishlist::create([
                'user_id' => $customer->id,
                'product_id' => $products[($index - 1) % $products->count()]->id,
            ]);
        }

        $addresses = UserAddress::query()->orderBy('id')->get();

        foreach (range(1, 5) as $index) {
            $customer = $customers[($index - 1) % $customers->count()];
            $address = $addresses->firstWhere('user_id', $customer->id);
            $variant = $variants[($index - 1) % $variants->count()];
            $quantity = 1 + ($index % 2);
            $subtotal = (float) $variant->price * $quantity;
            $discount = $index % 2 === 0 ? 50 : 0;
            $total = max(0, $subtotal - $discount);

            $order = Order::create([
                'user_id' => $customer->id,
                'address_id' => $address?->id,
                'order_number' => 'ORD-DEMO-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => 0,
                'total_amount' => $total,
                'coupon_code' => $discount > 0 ? 'WELCOME10' : null,
                'status' => ['pending', 'confirmed', 'processing', 'delivered', 'completed'][$index - 1],
                'payment_status' => $index > 2 ? 'paid' : 'unpaid',
                'notes' => 'Demo order for frontend API testing.',
                'created_at' => Carbon::now()->subDays(6 - $index),
                'updated_at' => Carbon::now()->subDays(6 - $index),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $variant->product_id,
                'variant_id' => $variant->id,
                'product_name' => $variant->product->name,
                'variant_name' => $variant->name,
                'price' => $variant->price,
                'quantity' => $quantity,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $index % 2 === 0 ? 'razorpay' : 'cod',
                'transaction_id' => 'TXN-DEMO-'.str_pad((string) $index, 5, '0', STR_PAD_LEFT),
                'amount' => $total,
                'status' => $index > 2 ? 'success' : 'initiated',
                'gateway_payload' => ['source' => 'demo-seeder', 'order' => $order->order_number],
                'paid_at' => $index > 2 ? Carbon::now()->subDays(6 - $index) : null,
            ]);
        }

        $welcomeCoupon = Coupon::create([
            'code' => 'WELCOME10',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'min_order_amount' => 299,
            'max_discount' => 150,
            'expiry_date' => Carbon::now()->addMonths(2),
            'usage_limit' => 200,
            'per_user_limit' => 5,
            'required_completed_orders' => null,
            'is_active' => true,
        ]);

        foreach (Order::query()->whereNotNull('coupon_code')->get() as $order) {
            CouponUsage::create([
                'coupon_id' => $welcomeCoupon->id,
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'used_at' => $order->created_at,
            ]);
        }

        foreach (range(1, 5) as $index) {
            Review::create([
                'product_id' => $products[($index - 1) % $products->count()]->id,
                'user_id' => $customers[($index - 1) % $customers->count()]->id,
                'rating' => ($index % 5) + 1,
                'review' => 'Demo review '.$index.' for product detail and reviews.',
                'created_at' => Carbon::now()->subDays(5 - $index),
                'updated_at' => Carbon::now()->subDays(5 - $index),
            ]);
        }

        foreach (range(1, 5) as $index) {
            $title = 'Demo Blog Post '.$index;
            BlogPost::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'Short excerpt for '.$title,
                'content' => $title.' full content.',
                'featured_image_path' => $demoImage('blog-'.$index, 1200, 800),
                'status' => true,
                'published_at' => Carbon::now()->subDays($index),
                'meta_title' => $title,
                'meta_description' => 'SEO description for '.$title,
            ]);
        }

        foreach ($products->values() as $index => $product) {
            HeroSection::create([
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'product_image_path' => $product->image_1,
                'status' => true,
                'sort_order' => $index,
            ]);
        }

        $this->command?->info('Frontend demo data seeded successfully.');
        $this->command?->info('Customer login: test@example.com / password');
        $this->command?->info('Admin login: admin@example.com / password');
    }
}
