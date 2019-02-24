<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('checkout_user_id');
            $table->integer('resolve_user_id');
            $table->integer('delivery_user_id');
            $table->enum('status', ['pending', 'resolved', 'delivered']);
            $table->decimal('deposit', 10, 2)->default('0.00');
            $table->dateTime('checkout_at');
            $table->dateTime('resolved_at');
            $table->dateTime('delivered_at');
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
        Schema::dropIfExists('orders');
    }
}
