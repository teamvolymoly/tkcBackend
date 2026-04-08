<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\HeroSection;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductNutrition;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Models\Review;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class FrontendDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('Seeding frontend demo data...');

        $hasComparePrice = Schema::hasColumn('product_variants', 'compare_price');
        $hasVariantDefault = Schema::hasColumn('product_variants', 'is_default');
        $hasVariantImageUrl = Schema::hasColumn('product_variant_images', 'image_url');
        $hasIngredientImagePath = Schema::hasColumn('product_ingredients', 'image_path');

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
            Inventory::class,
            ProductVariantImage::class,
            ProductVariant::class,
            ProductIngredient::class,
            ProductNutrition::class,
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

        $parentNames = [
            'Kahwa Blends',
            'Herbal Tea',
            'Green Tea',
            'Black Tea',
            'Wellness Tea',
            'Iced Tea',
            'Gift Boxes',
            'Tea Accessories',
            'Seasonal Editions',
            'Signature Tea',
        ];

        $parentCategories = collect($parentNames)->values()->map(function (string $name, int $index) use ($demoImage) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Demo category {$name} for frontend API testing.",
                'image_path' => $demoImage('category-'.$index, 900, 900),
                'status' => true,
            ]);
        });

        $subCategories = $parentCategories->map(function (Category $category, int $index) use ($demoImage) {
            $name = $category->name.' Special';

            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Subcategory for {$category->name}.",
                'image_path' => $demoImage('subcategory-'.$index, 900, 900),
                'parent_id' => $category->id,
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

        foreach (range(1, 9) as $index) {
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

        $productNames = [
            'Hibiscus Kahwa',
            'Mint Kahwa',
            'Kashmiri Kahwa',
            'Oolong Kahwa',
            'Chamomile Tea',
            'Detox Green Tea',
            'Immunity Blend',
            'Saffron Elixir',
            'Rose Herbal Infusion',
            'Lemongrass Refresh',
        ];

        $products = collect();
        $variantPool = collect();

        foreach ($productNames as $index => $productName) {
            $category = $parentCategories[$index];
            $subcategory = $subCategories[$index];

            $product = Product::create([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'name' => $productName,
                'slug' => Str::slug($productName),
                'short_description' => "{$productName} short description for product listing and product detail page.",
                'allergic_information' => $index % 2 === 0 ? 'Contains almonds and spices.' : 'Contains natural botanicals.',
                'tea_type' => $index % 2 === 0 ? 'With almonds & cardamom' : 'Herbal infusion',
                'disclaimer' => 'This is demo data intended for frontend and API testing.',
                'description' => "{$productName} is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.",
                'ingredients' => 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint',
                'features' => [
                    ['icon' => 'leaf', 'text' => 'Premium botanical blend'],
                    ['icon' => 'cup', 'text' => 'Balanced everyday ritual'],
                ],
                'status' => true,
            ]);

            $ingredientSeeds = [
                ['name' => 'Chamomile Flower', 'value' => 'Chamomile Flower'],
                ['name' => 'Green Tea', 'value' => 'Green Tea'],
                ['name' => 'Lemongrass', 'value' => 'Lemongrass'],
                ['name' => 'Orange Peel', 'value' => 'Orange Peel'],
            ];

            foreach ($ingredientSeeds as $ingredientIndex => $ingredient) {
                $payload = [
                    'product_id' => $product->id,
                    'name' => $ingredient['name'],
                    'value' => $ingredient['value'],
                    'sort_order' => $ingredientIndex,
                ];

                if ($hasIngredientImagePath) {
                    $payload['image_path'] = $demoImage('ingredient-'.$index.'-'.$ingredientIndex, 600, 600);
                }

                ProductIngredient::create($payload);
            }

            $nutritionSeeds = [
                ['nutrient' => 'Energy', 'value' => (string) (8 + $index), 'unit' => 'kcal'],
                ['nutrient' => 'Carbohydrate', 'value' => (string) (2 + $index), 'unit' => 'g'],
                ['nutrient' => 'Sugar', 'value' => (string) max(1, $index - 1), 'unit' => 'g'],
                ['nutrient' => 'Protein', 'value' => (string) max(1, (int) floor(($index + 1) / 2)), 'unit' => 'g'],
            ];

            foreach ($nutritionSeeds as $nutrition) {
                ProductNutrition::create([
                    'product_id' => $product->id,
                    'nutrient' => $nutrition['nutrient'],
                    'value' => $nutrition['value'],
                    'unit' => $nutrition['unit'],
                ]);
            }

            $variantSeeds = [
                ['size' => '100g', 'cups' => '50 cups', 'price' => 399 + (($index + 1) * 10), 'compare' => 499 + (($index + 1) * 10), 'default' => true],
                ['size' => '200g', 'cups' => '100 cups', 'price' => 749 + (($index + 1) * 10), 'compare' => 849 + (($index + 1) * 10), 'default' => false],
            ];

            foreach ($variantSeeds as $variantIndex => $variantSeed) {
                $variantPayload = [
                    'product_id' => $product->id,
                    'variant_name' => $variantSeed['size'],
                    'size' => $variantSeed['size'],
                    'color' => null,
                    'sku' => 'TKC-'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'-'.($variantIndex + 1),
                    'price' => $variantSeed['price'],
                    'stock' => 20 + (($index + 1) * 3) + ($variantIndex * 5),
                    'weight' => $variantIndex === 0 ? 100 : 200,
                    'dimensions' => '10x10x18 cm',
                    'net_weight' => $variantSeed['size'],
                    'tags' => [$variantSeed['cups'], 'best seller'],
                    'brewing_rituals' => [
                        ['group' => 'Hot Brew', 'title' => 'Tea', 'icon' => 'leaf', 'text' => '1 tsp / 2 g', 'value' => '1 tsp / 2 g'],
                        ['group' => 'Hot Brew', 'title' => 'Water', 'icon' => 'cup', 'text' => '200ml', 'value' => '200ml'],
                        ['group' => 'Hot Brew', 'title' => 'Steep', 'icon' => 'timer', 'text' => '3 - 5 mins', 'value' => '3 - 5 mins'],
                        ['group' => 'Iced Brew', 'title' => 'Serve', 'icon' => 'glass', 'text' => 'Refrigerate and add ice', 'value' => 'Serve chilled'],
                    ],
                    'status' => true,
                ];

                if ($hasComparePrice) {
                    $variantPayload['compare_price'] = $variantSeed['compare'];
                }

                if ($hasVariantDefault) {
                    $variantPayload['is_default'] = $variantSeed['default'];
                }

                $variant = ProductVariant::create($variantPayload);

                Inventory::create([
                    'variant_id' => $variant->id,
                    'stock' => $variant->stock,
                    'reserved_stock' => 0,
                    'warehouse' => 'default',
                ]);

                foreach (range(1, 2) as $imageIndex) {
                    $imageUrl = $demoImage('variant-'.$index.'-'.$variantIndex.'-'.$imageIndex, 1000, 1000);
                    $imagePayload = [
                        'variant_id' => $variant->id,
                        'image_path' => $imageUrl,
                        'is_primary' => $imageIndex === 1,
                        'sort_order' => $imageIndex - 1,
                    ];

                    if ($hasVariantImageUrl) {
                        $imagePayload['image_url'] = $imageUrl;
                    }

                    ProductVariantImage::create($imagePayload);
                }

                $variantPool->push($variant->fresh());
            }

            $products->push($product->fresh());
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

        $addresses = UserAddress::query()->orderBy('id')->get();

        foreach (range(1, 10) as $index) {
            $customer = $customers[($index - 1) % $customers->count()];
            $cart = Cart::firstOrCreate(['user_id' => $customer->id]);
            CartItem::create([
                'cart_id' => $cart->id,
                'variant_id' => $variantPool[($index - 1) % $variantPool->count()]->id,
                'quantity' => ($index % 3) + 1,
            ]);
        }

        foreach (range(1, 10) as $index) {
            Wishlist::create([
                'user_id' => $customers[($index - 1) % $customers->count()]->id,
                'product_id' => $products[($index - 1) % $products->count()]->id,
            ]);
        }

        foreach (range(1, 10) as $index) {
            $customer = $customers[($index - 1) % $customers->count()];
            $address = $addresses->firstWhere('user_id', $customer->id);
            $variant = $variantPool[($index - 1) % $variantPool->count()];
            $quantity = ($index % 2) + 1;
            $subtotal = (float) $variant->price * $quantity;
            $discount = $index % 3 === 0 ? 50 : 0;
            $total = max(0, $subtotal - $discount);
            $status = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'][$index % 5];
            $paymentStatus = in_array($status, ['confirmed', 'shipped', 'delivered', 'completed'], true) ? 'paid' : 'unpaid';

            $order = Order::create([
                'user_id' => $customer->id,
                'address_id' => $address?->id,
                'order_number' => 'ORD-DEMO-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => 0,
                'total_amount' => $total,
                'coupon_code' => $discount > 0 ? 'WELCOME10' : null,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'notes' => 'Demo order for frontend API testing.',
                'created_at' => Carbon::now()->subDays(11 - $index),
                'updated_at' => Carbon::now()->subDays(max(0, 10 - $index)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $variant->product_id,
                'variant_id' => $variant->id,
                'product_name' => $variant->product->name,
                'variant_name' => $variant->variant_name,
                'price' => $variant->price,
                'quantity' => $quantity,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $index % 2 === 0 ? 'razorpay' : 'cod',
                'transaction_id' => 'TXN-DEMO-'.str_pad((string) $index, 5, '0', STR_PAD_LEFT),
                'amount' => $total,
                'status' => $paymentStatus === 'paid' ? 'success' : 'initiated',
                'gateway_payload' => ['source' => 'demo-seeder', 'order' => $order->order_number],
                'paid_at' => $paymentStatus === 'paid' ? Carbon::now()->subDays(max(0, 10 - $index)) : null,
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

        foreach (range(2, 10) as $index) {
            Coupon::create([
                'code' => 'DEMO'.str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'discount_type' => $index % 2 === 0 ? 'percent' : 'fixed',
                'discount_value' => $index % 2 === 0 ? 5 + $index : 50 + ($index * 10),
                'min_order_amount' => 199 + ($index * 20),
                'max_discount' => $index % 2 === 0 ? 200 : null,
                'expiry_date' => Carbon::now()->addDays(15 + $index),
                'usage_limit' => 100,
                'per_user_limit' => 2,
                'required_completed_orders' => $index > 7 ? 1 : null,
                'is_active' => true,
            ]);
        }

        foreach (Order::query()->whereNotNull('coupon_code')->take(3)->get() as $order) {
            CouponUsage::create([
                'coupon_id' => $welcomeCoupon->id,
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'used_at' => $order->created_at,
            ]);
        }

        foreach (range(1, 10) as $index) {
            Review::create([
                'product_id' => $products[($index - 1) % $products->count()]->id,
                'user_id' => $customers[($index - 1) % $customers->count()]->id,
                'rating' => ($index % 5) + 1,
                'review' => 'Demo review '.$index.' for product API, reviews list, and product detail page testing.',
                'created_at' => Carbon::now()->subDays(10 - $index),
                'updated_at' => Carbon::now()->subDays(10 - $index),
            ]);
        }

        foreach (range(1, 10) as $index) {
            $title = 'Demo Blog Post '.$index;
            BlogPost::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'Short excerpt for '.$title,
                'content' => $title.' full content for frontend blog APIs and cards.',
                'featured_image_path' => $demoImage('blog-'.$index, 1200, 800),
                'status' => true,
                'published_at' => Carbon::now()->subDays($index),
                'meta_title' => $title,
                'meta_description' => 'SEO description for '.$title,
            ]);
        }

        foreach ($products->take(10)->values() as $index => $product) {
            $heroImage = optional($product->defaultVariant?->primaryImage)->image_path ?: $demoImage('hero-'.$index, 1400, 900);

            HeroSection::create([
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'product_image_path' => $heroImage,
                'status' => true,
                'sort_order' => $index,
            ]);
        }

        $this->command?->info('Frontend demo data seeded successfully.');
        $this->command?->info('Customer login: test@example.com / password');
        $this->command?->info('Admin login: admin@example.com / password');
    }
}

