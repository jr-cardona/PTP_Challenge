<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('quantity');
            $table->float('unit_price')->unsigned();
            $table->float('total_price')->unsigned();
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('product_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_product');
    }
}
