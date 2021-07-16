<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplierbill_id');
            $table->foreign('supplierbill_id')->references('id')->on('supplierbills')->onDelete('cascade');
            $table->text('title');
            $table->decimal('amount',18,2);
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
        Schema::dropIfExists('bill_expenses');
    }
}
