<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     * Empresas
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('cellphone');
            $table->string('cpf')->unique();
            $table->string('oab');
            $table->string('uf_oab');
            $table->string('qtd_processes');
            $table->string('email');
            $table->enum('payment_status', ['testing', 'active', 'canceled'])->default('testing');
            $table->string('payment_id');
            $table->string('identify');

            $table->unsignedBigInteger('plan_id')->nullable();

            $table->string('subdomain')->unique();
            $table->string('db_database')->unique();
            $table->string('db_host');
            $table->string('db_username');
            $table->string('db_password');
            $table->timestamps();


            $table->foreign('plan_id')
                  ->references('id')
                  ->on('plans');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
