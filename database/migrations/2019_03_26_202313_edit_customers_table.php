<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EditCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE customers MODIFY COLUMN sex VARCHAR(10) NOT NULL DEFAULT "male"');

        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone', 20)->change();
            $table->string('ic_number', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE customers MODIFY COLUMN sex ENUM("male", "female", "others")');

        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone', 15)->change();
            $table->string('ic_number', 12)->change();
        });
    }
}
