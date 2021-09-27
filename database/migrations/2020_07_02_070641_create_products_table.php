<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('title',255);
            $table->text('product_description');
            $table->string('vendor',255);
            $table->string('product_type',255);
            $table->string('price',15);
            $table->string('image',255);
            $table->string('quantity',255);
            $table->string('barcode',255);                   
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
}
