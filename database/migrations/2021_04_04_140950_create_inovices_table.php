<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInovicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->string('buyer_name');
            $table->double('total_price')->default(0);
            $table->double('actual_price')->default(0); // the price without 'kasr'
            $table->double('total_weight_18')->default(0);
            $table->double('total_weight_21')->default(0);
            $table->double('from_buyer_total_weight_18')->default(0);
            $table->double('from_buyer_total_weight_21')->default(0);
            $table->double('paid_in_cache')->default(0);
            $table->double('paid_in_visa')->default(0);
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
        Schema::dropIfExists('inovices');
    }
}
