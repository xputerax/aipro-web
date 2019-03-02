<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class OrdersResolveUserIdDeliveryUserIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE orders MODIFY resolve_user_id INT(11) NULL');
        DB::statement('ALTER TABLE orders MODIFY delivery_user_id INT(11) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE orders MODIFY resolve_user_id INT(11) NOT NULL');
        DB::statement('ALTER TABLE orders MODIFY delivery_user_id INT(11) NOT NULL');
    }
}
