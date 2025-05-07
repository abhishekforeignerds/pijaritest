<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',
            'customer-view',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-view',
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'order-view',
            'service_city-list',
            'service_city-create',
            'service_city-edit',
            'service_city-delete',
            'setting-list',
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'banner-list',
            'banner-create',
            'banner-edit',
            'banner-delete',
            'blog-list',
            'blog-create',
            'blog-edit',
            'blog-delete',
            'blog-view',
            'testimonial-list',
            'testimonial-create',
            'testimonial-edit',
            'testimonial-delete',
            'testimonial-view',
            'kundali-list',
            'kundali-create',
            'kundali-edit',
            'kundali-delete',
            'kundali-view',
            'language-list',
            'language-create',
            'language-edit',
            'language-delete',
            'language-view',
            'pincode-list',
            'pincode-create',
            'pincode-edit',
            'pincode-delete',
            'pincode-view',
            'app_setup-view',
            'policy-view',
            'enquiry-list',
            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'roles-view',
            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete',
            'staff-view',
        ];


        foreach ($permissions as $permission) {
            $data = explode('-', $permission);

            $permissions = Permission::where('name', $permission)->first();
            if (!$permissions) {
                $permissions = new Permission;
            }
            $permissions->name = $permission;
            $permissions->parent_name = $data[0];
            $permissions->guard_name = 'admin';
            $permissions->save();
        }
    }
}
