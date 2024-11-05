<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        Product::insert([
            [
                'name'=>'Halda Valley Black Tea 120g', 
                'description' => 'Fertile soils, easing rainfall, warming sun, and precise care in every processing step are all the elements that bring distinction to the Halda Valley brand and its premium-quality Black tea', 
                'cost_price' => 145,
                'mrp_price' => 180,
                'quantity' => 10,
                'sku' => 'SKU001',
            ], 
            [
                'name'=>'Halda Valley Black Tea 200g', 
                'description' => 'Fertile soils, easing rainfall, warming sun, and precise care in every processing step are all the elements that bring distinction to the Halda Valley brand and its premium-quality Black tea', 
                'cost_price' => 245,
                'mrp_price' => 175,
                'quantity' => 10,
                'sku' => 'SKU002',
            ], 
            [
                'name'=>'Halda Valley Black Tea 400g', 
                'description' => 'Fertile soils, easing rainfall, warming sun, and precise care in every processing step are all the elements that bring distinction to the Halda Valley brand and its premium-quality Black tea', 
                'cost_price' => 485,
                'mrp_price' => 325,
                'quantity' => 10,
                'sku' => 'SKU003',
            ], 
            [
                'name'=>'Halda Valley Black Tea 450g', 
                'description' => 'Fertile soils, easing rainfall, warming sun, and precise care in every processing step are all the elements that bring distinction to the Halda Valley brand and its premium-quality Black tea', 
                'cost_price' => 570,
                'mrp_price' => 385,
                'quantity' => 10,
                'sku' => 'SKU004',
            ]
        ]); 
    }
}
