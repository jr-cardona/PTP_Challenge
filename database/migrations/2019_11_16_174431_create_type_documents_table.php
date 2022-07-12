<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fullname');
            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => 'TypeDocumentsTableSeeder', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_documents');
    }
}
