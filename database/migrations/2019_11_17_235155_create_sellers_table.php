<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('document')->unique();
            $table->unsignedInteger('type_document_id');
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number');
            $table->string('address');
            $table->string('email')->unique();
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
