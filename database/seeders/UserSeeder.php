<?php

namespace Database\Seeders;

use App\Models\StoreBanner;
use App\Models\Category;
use App\Models\Customer;
use App\Models\StoreOrder;
use App\Models\Product;
use App\Models\ProductAdditional;
use App\Models\ProductConfiguration;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use App\Models\ProductReplacement;
use App\Models\StoreCategory;
use App\Models\StoreCustomer;
use App\Models\StoreProduct;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserSubscription;
use App\Models\Waiter;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::factory()
            ->count(1)
            ->has(
                UserStore::factory()
                    ->has(StoreBanner::factory()->count(3), 'banners')
                    ->has(StoreCategory::factory()->count(10), 'categories')
                    ->has(StoreProduct::factory()
                        ->has(ProductPrice::factory()->count(1), 'prices')
                        ->has(ProductConfiguration::factory()->count(1), 'configuration')
                        ->has(ProductPhoto::factory()->count(3), 'photos')
                        ->has(ProductAdditional::factory()->count(3), 'additionals')
                        ->has(ProductReplacement::factory()->count(3), 'replacements')
                            ->count(30), 'products')
                    ->has(StoreCustomer::factory()->count(30), 'customers')
                        ->count(1), 'stores')
                    ->create();

        StoreOrder::factory()
            ->count(50)
            ->create([
                'user_store_id' => UserStore::first()->id
            ]);
    }

}
