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
            $table->date('issued_at');
            $table->date('expires_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('annulled_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->string('description')->nullable();
            $table->string('annulment_reason')->nullable();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('creator_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
