<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDateRentedColumnAndDateAvailableColumnOnNewProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dateTime('date_rented')->nullable()->change();
            $table->dateTime('date_available')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dateTime('date_rented')->nullable(false)->change();
            $table->dateTime('date_available')->nullable(false)->change();
        });
    }
}
