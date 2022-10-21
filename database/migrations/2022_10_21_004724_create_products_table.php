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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('codeProduct')->unique();
            $table->string('nameProduct');
            $table->decimal('priceSaleProduct', 8, 2);
            $table->integer('porcPriceTrustProduct');
            $table->decimal('priceTrustProduct', 8, 2);
            $table->integer('cantStockProduct');
            $table->integer('cantStockMinProduct');
            $table->uuid('uuid');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
};
