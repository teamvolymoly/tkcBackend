<?php

namespace App\Services;

use App\Models\Permission;

class AdminPermissionRegistry
{
    public static function groups(): array
    {
        return [
            [
                'key' => 'access',
                'label' => 'Admin Access',
                'permissions' => [
                    ['name' => 'admin.access', 'label' => 'Admin panel access', 'description' => 'Allows login and access to the admin panel shell.'],
                ],
            ],
            [
                'key' => 'dashboard',
                'label' => 'Dashboard',
                'permissions' => [
                    ['name' => 'dashboard.view', 'label' => 'View dashboard', 'description' => 'Can view admin dashboard metrics and overview cards.'],
                ],
            ],
            [
                'key' => 'orders',
                'label' => 'Orders',
                'permissions' => [
                    ['name' => 'orders.view', 'label' => 'View orders', 'description' => 'Can open order lists and order details.'],
                    ['name' => 'orders.update', 'label' => 'Update order status', 'description' => 'Can change order status and bulk status updates.'],
                ],
            ],
            [
                'key' => 'payments',
                'label' => 'Payments',
                'permissions' => [
                    ['name' => 'payments.view', 'label' => 'View payments', 'description' => 'Can view payment records and payment details.'],
                    ['name' => 'payments.update', 'label' => 'Update payments', 'description' => 'Can update payment records from admin.'],
                ],
            ],
            [
                'key' => 'products',
                'label' => 'Products',
                'permissions' => [
                    ['name' => 'products.view', 'label' => 'View products', 'description' => 'Can browse product listing and product details.'],
                    ['name' => 'products.create', 'label' => 'Create products', 'description' => 'Can add new products and product variants.'],
                    ['name' => 'products.update', 'label' => 'Edit products', 'description' => 'Can update product content and variant records.'],
                    ['name' => 'products.delete', 'label' => 'Delete products', 'description' => 'Can delete products and product-related child records.'],
                ],
            ],
            [
                'key' => 'categories',
                'label' => 'Categories',
                'permissions' => [
                    ['name' => 'categories.view', 'label' => 'View categories', 'description' => 'Can browse category listing and forms.'],
                    ['name' => 'categories.create', 'label' => 'Create categories', 'description' => 'Can add categories, including quick category creation.'],
                    ['name' => 'categories.update', 'label' => 'Edit categories', 'description' => 'Can update categories.'],
                    ['name' => 'categories.delete', 'label' => 'Delete categories', 'description' => 'Can remove categories and bulk delete them.'],
                ],
            ],
            [
                'key' => 'coupons',
                'label' => 'Coupons',
                'permissions' => [
                    ['name' => 'coupons.view', 'label' => 'View coupons', 'description' => 'Can browse coupon listing and details.'],
                    ['name' => 'coupons.create', 'label' => 'Create coupons', 'description' => 'Can add new coupons.'],
                    ['name' => 'coupons.update', 'label' => 'Edit coupons', 'description' => 'Can update coupon records.'],
                    ['name' => 'coupons.delete', 'label' => 'Delete coupons', 'description' => 'Can remove coupons.'],
                ],
            ],
            [
                'key' => 'users',
                'label' => 'Users',
                'permissions' => [
                    ['name' => 'users.view', 'label' => 'View users', 'description' => 'Can browse user accounts and user details.'],
                    ['name' => 'users.create', 'label' => 'Create users', 'description' => 'Can create admin or customer accounts.'],
                    ['name' => 'users.update', 'label' => 'Edit users', 'description' => 'Can edit user profiles and assigned roles.'],
                    ['name' => 'users.delete', 'label' => 'Delete users', 'description' => 'Can remove user accounts and bulk delete users.'],
                ],
            ],
            [
                'key' => 'reviews',
                'label' => 'Reviews',
                'permissions' => [
                    ['name' => 'reviews.view', 'label' => 'View reviews', 'description' => 'Can access review listing and review detail screens.'],
                    ['name' => 'reviews.delete', 'label' => 'Delete reviews', 'description' => 'Can remove customer reviews.'],
                ],
            ],
            [
                'key' => 'carts',
                'label' => 'Carts',
                'permissions' => [
                    ['name' => 'carts.view', 'label' => 'View carts', 'description' => 'Can inspect customer carts.'],
                ],
            ],
            [
                'key' => 'wishlists',
                'label' => 'Wishlists',
                'permissions' => [
                    ['name' => 'wishlists.view', 'label' => 'View wishlists', 'description' => 'Can inspect customer wishlists.'],
                    ['name' => 'wishlists.delete', 'label' => 'Delete wishlist items', 'description' => 'Can remove wishlist records from admin.'],
                ],
            ],
            [
                'key' => 'blogs',
                'label' => 'Blogs',
                'permissions' => [
                    ['name' => 'blogs.view', 'label' => 'View blogs', 'description' => 'Can browse blog listing and blog details.'],
                    ['name' => 'blogs.create', 'label' => 'Create blogs', 'description' => 'Can create blog posts.'],
                    ['name' => 'blogs.update', 'label' => 'Edit blogs', 'description' => 'Can update blog posts.'],
                    ['name' => 'blogs.delete', 'label' => 'Delete blogs', 'description' => 'Can remove blog posts.'],
                ],
            ],
            [
                'key' => 'hero_sections',
                'label' => 'Hero Sections',
                'permissions' => [
                    ['name' => 'hero_sections.view', 'label' => 'View hero sections', 'description' => 'Can browse hero section records inside settings.'],
                    ['name' => 'hero_sections.create', 'label' => 'Create hero sections', 'description' => 'Can create new hero section records.'],
                    ['name' => 'hero_sections.update', 'label' => 'Edit hero sections', 'description' => 'Can update hero section content.'],
                    ['name' => 'hero_sections.delete', 'label' => 'Delete hero sections', 'description' => 'Can remove hero section entries.'],
                ],
            ],
            [
                'key' => 'roles',
                'label' => 'Roles & Permissions',
                'permissions' => [
                    ['name' => 'roles.view', 'label' => 'View roles', 'description' => 'Can browse roles and permissions.'],
                    ['name' => 'roles.create', 'label' => 'Create roles', 'description' => 'Can create new roles.'],
                    ['name' => 'roles.update', 'label' => 'Edit roles', 'description' => 'Can update role names and permission assignments.'],
                    ['name' => 'roles.delete', 'label' => 'Delete roles', 'description' => 'Can delete roles that are not protected or in use.'],
                ],
            ],
            [
                'key' => 'profile',
                'label' => 'Profile',
                'permissions' => [
                    ['name' => 'profile.view', 'label' => 'View profile', 'description' => 'Can open own admin profile.'],
                    ['name' => 'profile.update', 'label' => 'Update profile', 'description' => 'Can update own profile details.'],
                ],
            ],
        ];
    }

    public static function permissionNames(): array
    {
        return collect(static::groups())
            ->flatMap(fn (array $group) => collect($group['permissions'])->pluck('name'))
            ->values()
            ->all();
    }

    public static function ensurePermissionsExist(): void
    {
        $guardName = config('auth.defaults.guard', 'web');

        foreach (static::permissionNames() as $permissionName) {
            Permission::findOrCreate($permissionName, $guardName);
        }
    }

    public static function defaultRolePermissions(): array
    {
        return [
            'admin' => static::permissionNames(),
            'manager' => [
                'admin.access', 'dashboard.view', 'orders.view', 'orders.update', 'payments.view', 'payments.update',
                'products.view', 'products.create', 'products.update', 'categories.view', 'categories.create', 'categories.update',
                'coupons.view', 'coupons.create', 'coupons.update',
                'users.view', 'reviews.view', 'reviews.delete', 'carts.view', 'wishlists.view',
                'blogs.view', 'blogs.create', 'blogs.update', 'hero_sections.view', 'hero_sections.create', 'hero_sections.update',
                'profile.view', 'profile.update', 'roles.view',
            ],
            'staff' => [
                'admin.access', 'dashboard.view', 'orders.view', 'payments.view', 'products.view',
                'categories.view', 'coupons.view', 'users.view', 'reviews.view',
                'carts.view', 'wishlists.view', 'blogs.view', 'hero_sections.view', 'profile.view', 'profile.update',
            ],
            'customer' => [],
        ];
    }

    public static function protectedRoles(): array
    {
        return ['admin', 'customer'];
    }
}
