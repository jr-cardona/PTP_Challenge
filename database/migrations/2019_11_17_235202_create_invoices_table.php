<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('issued_at');
            $table->dateTime('overdued_at');
            $table->dateTime('received_at')->nullable();
            $table->float('vat')->unsigned();
            $table->double('total')->unsigned()->default(0);
            $table->string('status');
            $table->string('description')->nullable();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
