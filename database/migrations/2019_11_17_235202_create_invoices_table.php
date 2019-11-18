<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->dateTime('expedition_date');
            $table->dateTime('due_date');
            $table->dateTime('invoice_date');
            $table->unsignedInteger('number')->unique();
            $table->float('vat')->unsigned();
            $table->double('total');
            $table->string('status');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
