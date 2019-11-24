<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('type_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('fullname');
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_documents');
    }
}
