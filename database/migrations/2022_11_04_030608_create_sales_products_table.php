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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('saleId')->unsigned();
            $table->foreign('saleId')->references('id')->on('sales');
            $table->string('idProduct');
            $table->string('name');
            $table->integer('cantProduct');
            $table->decimal('priceProductSale', 14, 2);
            $table->decimal('priceProductTrust', 14, 2);
            $table->decimal('subtotal', 14, 2);
            $table->SoftDeletes();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_products');
    }
};
