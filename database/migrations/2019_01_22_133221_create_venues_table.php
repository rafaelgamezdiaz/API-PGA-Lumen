<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client')->unique()->index()->unsigned();
            $table->string('name')->index()->nullable();
            $table->string('description')->index()->nullable();
            $table->integer('account')->index()->unsigned();
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('client')->references('id')->on('clients')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}
