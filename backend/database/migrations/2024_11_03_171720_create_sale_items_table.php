<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); // Reference to sales table
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Reference to products table
            $table->integer('quantity'); // Quantity of the specific product sold
            $table->decimal('cost_price', 10, 2); // Cost Price per unit of the product
            $table->decimal('mrp_price', 10, 2); // Price per unit of the product
            $table->decimal('discount', 10, 2); // Discount amount
            $table->decimal('total', 10, 2); // Total for this item (quantity * price)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
};
