<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->bigInteger('katagori_id')->unsigned();
            $table->string('nama');
            $table->integer('harga');
            $table->string('warna');
            $table->enum('kondisi',['baru','lama']);
            $table->longText('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('katagori_id')->references('katagori_id')->on('katagori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
