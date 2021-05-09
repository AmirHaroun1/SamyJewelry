<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id');
            $table->string('phone')->nullable();
            $table->integer('number_of_items')->default(0);
            $table->double('current_weight_21')->default(0);
            $table->double('current_weight_18')->default(0);
            $table->integer('bracelets_number_of_items')->default(0);
            $table->double('bracelets_current_weight_21')->default(0);
            $table->double('bracelets_current_weight_18')->default(0);
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
        Schema::dropIfExists('employees');
    }
}
