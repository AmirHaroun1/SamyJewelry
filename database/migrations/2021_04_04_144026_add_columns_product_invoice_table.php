<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsProductInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_invoices', function (Blueprint $table) {
            //
            $table->string('number_of_items')->after('invoice_id');
            $table->double('product_items_price')->after('number_of_items');
            $table->double('weight')->default('0')->after('product_items_price');
            $table->string('weight_type')->after('weight');
            $table->foreignId('owner_employee')->nullable();
            $table->foreign('owner_employee')
                ->references('id')
                ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_invoices', function (Blueprint $table) {
            //
        });
    }
}
