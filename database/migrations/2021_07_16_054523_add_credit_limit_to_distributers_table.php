<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditLimitToDistributersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributers', function (Blueprint $table) {
            $table->integer('credit_days')->default(15);
            $table->integer('credit_limit')->default(0);
        });

        Schema::table('supplierbills', function (Blueprint $table) {
            $table->boolean('canceled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributers', function (Blueprint $table) {
            $table->dropColumn('credit_days');
            $table->dropColumn('credit_limit');
        });
        Schema::table('supplier_bills', function (Blueprint $table) {
            $table->dropColumn('canceled');
        });
    }
}
