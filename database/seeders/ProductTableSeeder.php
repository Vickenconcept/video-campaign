<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['product_id' => 422617, 'name' => 'App Features Only', 'funnel' => 'FE'],

            ['product_id' => 422619, 'name' => 'Full Access Bundle', 'funnel' => 'Bundle'],

            ['product_id' => 422739, 'name' => 'Full Access OTO1', 'funnel' => 'OTO1'],
            ['product_id' => 422755, 'name' => 'Full Access OTO1', 'funnel' => 'OTO1'],

            ['product_id' => 422743, 'name' => 'DFY Video Agency Setup', 'funnel' => 'OTO2'],
            ['product_id' => 422759, 'name' => 'DFY Video Agency Setup', 'funnel' => 'OTO2'],

            ['product_id' => 422745, 'name' => 'DFY Unlimited Traffic', 'funnel' => 'OTO3'],
            ['product_id' => 422761, 'name' => 'DFY Unlimited Traffic', 'funnel' => 'OTO3'],

            ['product_id' => 422747, 'name' => 'Reseller Access', 'funnel' => 'OTO4'],
            ['product_id' => 422763, 'name' => 'Reseller Access', 'funnel' => 'OTO4'],

            ['product_id' => 422751, 'name' => 'Affiliate Marketing Training', 'funnel' => 'OTO5'],
            ['product_id' => 422765, 'name' => 'Affiliate Marketing Training', 'funnel' => 'OTO5'],
        ];



        foreach ($products as $product) {
            Product::firstOrCreate(
                ['product_id' => $product['product_id']], // Check for existence by product_id
                ['name' => $product['name'], 'funnel' => $product['funnel']] // Data to create if product_id doesn't exist
            );
        }
    }
}
