<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplingTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplyings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreign('supplying_id');
            $table->foreign('supplying_id')
                ->references('id')
                ->on('supplyings');
            $table->double('paid_weight_18')->default(0);
            $table->double('paid_weight_21')->default(0);
            $table->double('paid_money')->default(0);
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
        Schema::dropIfExists('supplings_transactions');
    }
}
