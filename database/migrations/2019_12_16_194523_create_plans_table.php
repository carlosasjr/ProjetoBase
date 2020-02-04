<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->unique();
            $table->double('price', 10, 2);

            $table->enum('frequency', ['day', 'week', 'month', 'year']);
            $table->integer('frequency_interval');
            $table->integer('cycles');
            $table->string('key_paypal')->nullable();
            $table->string('key_pagseguro')->nullable();

            $table->enum('state_paypal', ['created', 'active', 'inactive'])->default('inactive');
            $table->enum('state_pagseguro', ['created', 'active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('plans');
    }
}
