<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id');
            $table->integer('user_id');
            $table->integer('pegawai_id');
            $table->string('code');
            $table->string('nama');
            $table->string('harga')->nullable()->default(0);
            $table->string('diskon')->nullable()->default(0);
            $table->string('berat');
            $table->string('unit');
            $table->string('stock')->nullable()->default(0);
            $table->string('images')->nullable();
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
        Schema::dropIfExists('mst_produk');
    }
}
