<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->string('category');
            $table->string('sub_category');
            $table->string('item_type');
            $table->string('item_name', 255);
            $table->text('description');
            $table->string('item_condition');
            $table->string('age');
            $table->string('phone_code');
            $table->string('phone');
            $table->integer('rental_duration_daily');
            $table->integer('rental_duration_weekly');
            $table->integer('rental_duration_monthly');
            $table->double('daily_aed');
            $table->double('weekly_aed');
            $table->double('monthly_aed');
            $table->double('cash_deposit');
            $table->string('available_for_sale');
            $table->double('sale_price');
            $table->text('images');
            $table->text('primary_img');
            $table->string('location_1');
            $table->string('location_2');
            $table->string('street');
            $table->string('area');
            $table->string('city');
            $table->text('neighbourhood');
            $table->string('rent_status');
            $table->string('sale_status');
            $table->dateTime('date_rented');
            $table->dateTime('date_available');
            $table->string('listing_type');
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
}
