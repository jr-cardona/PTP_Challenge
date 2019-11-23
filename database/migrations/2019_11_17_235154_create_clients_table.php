<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('sic_code')->unique();
            $table->string('type_document');
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number');
            $table->string('address');
            $table->string('email')->unique();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
