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
        Schema::create('current_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('clientId')->unsigned();            
            // $table->foreign('clientId')->references('id')->on('clients');            
            $table->string('dniClient');
            $table->string('nameClient');
            $table->string('lastNameClient');
            $table->decimal('balance', 14, 2);
            $table->date('datelastaction');
            $table->integer('deudors')->nullable();
            $table->string('urlpdf')->nullable();
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
        Schema::dropIfExists('current_accounts');
    }
};
