<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchToSupplierbillitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplierbillitems', function (Blueprint $table) {
            $table->date('expiry_date')->nullable();
            $table->decimal('remaning',18,2)->default(0);
            $table->boolean('has_expairy')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplierbillitems', function (Blueprint $table) {
            $table->dropColumn('expiry_date');
            $table->dropColumn('remaning');
            $table->dropColumn('has_expairy');
        });
    }
}
