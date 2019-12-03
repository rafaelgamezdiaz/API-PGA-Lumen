<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni')->unique()->index();
            $table->string('name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->string('commerce_name')->index()->nullable();
            $table->string('description')->index()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('code')->nullable();
            $table->integer('type')->index()->nullable();
            $table->integer('status')->index();
            $table->integer('account')->index();
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('type')->references('id')->on('types')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
