<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBorrowerIdToWeightChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weight_change', function (Blueprint $table) {
            $table->foreignId('borrower_id')->nullable()->after('employee_id');
            $table->foreign('borrower_id')
                ->references('id')
                ->on('employees');

            $table->bigInteger('invoice_id')->nullable();
            $table->bigInteger('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weight_change', function (Blueprint $table) {
            //
        });
    }
}
