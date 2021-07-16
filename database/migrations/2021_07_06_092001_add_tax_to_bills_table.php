<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplierbills', function (Blueprint $table) {
            $table->decimal('taxable',18,2)->default(0);
            $table->decimal('tax',18,2)->default(0);
            $table->decimal('discount',18,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplierbills', function (Blueprint $table) {
            $table->dropColumn('taxable');
            $table->dropColumn('tax');
            $table->dropColumn('discount');
        });
    }
}
