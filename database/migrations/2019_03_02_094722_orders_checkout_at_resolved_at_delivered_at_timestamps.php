<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersCheckoutAtResolvedAtDeliveredAtTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE orders MODIFY checkout_at TIMESTAMP NULL DEFAULT NULL');
        DB::statement('ALTER TABLE orders MODIFY resolved_at TIMESTAMP NULL DEFAULT NULL');
        DB::statement('ALTER TABLE orders MODIFY delivered_at TIMESTAMP NULL DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE orders MODIFY checkout_at DATETIME NOT NULL');
        DB::statement('ALTER TABLE orders MODIFY resolved_at DATETIME NOT NULL');
        DB::statement('ALTER TABLE orders MODIFY delivered_at DATETIME NOT NULL');
    }
}
