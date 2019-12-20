<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('issued_at');
            $table->dateTime('overdued_at');
            $table->dateTime('received_at')->nullable();
            $table->float('vat')->unsigned();
            $table->string('description')->nullable();
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('seller_id');
            $table->string('number')->nullable()->unique();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
