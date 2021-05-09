<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangingWeightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_change', function (Blueprint $table) {
            $table->id();
            $table->double('original_weight');
            $table->double('weight_amount');
            $table->string('weight_type');

            $table->boolean('sold')->default(0);
            $table->boolean('is_bracelet')->default(0);


            $table->foreignId('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreignId('borrower_id');
            $table->foreign('borrower_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreignId('invoices_id');
            $table->foreign('invoices_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

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
        Schema::dropIfExists('weight_change');
    }
}
