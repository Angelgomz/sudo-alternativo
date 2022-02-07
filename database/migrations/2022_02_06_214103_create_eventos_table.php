<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('id_google');
            $table->string('nombre')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->string('eTag')->nullable();
            $table->longText('description')->nullable();
            $table->string('update_google')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('email_creator')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->dateTime('begin')->nullable();
            $table->dateTime('end')->nullable();
            $table->dateTime('created_por');
            $table->string('status')->nullable();
            $table->boolean('isActive');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('eventos');
    }
}
