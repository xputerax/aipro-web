<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeResolveUserIdAndDeliveryUserIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('ALTER TABLE `orders` CHANGE resolve_user_id ');
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->integer('resolve_user_id')->nullable()->change();
        //     $table->integer('delivery_user_id')->nullable()->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->integer('resolve_user_id')->change();
        //     $table->integer('delivery_user_id')->change();
        // });
    }
}
