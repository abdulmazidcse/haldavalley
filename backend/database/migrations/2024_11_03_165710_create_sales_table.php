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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('customer_name',30);
            $table->string('invoice_number',30); 
            $table->decimal('total', 10, 2); // Total amount
            $table->timestamp('sale_date'); // Date of sale
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
        Schema::dropIfExists('sales');
    }
};
