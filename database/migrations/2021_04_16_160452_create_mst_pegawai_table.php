<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->date('tgl_lahir')->nullable();
            $table->string('fullname');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('ktp', 16)->nullable();
            $table->string('photo', 100)->nullable();
            $table->longText('address')->nullable();
            $table->string('department', 100)->nullable();
            $table->string('devisi', 100)->nullable();
            $table->string('password');
            $table->boolean('verified')->nullable()->default(false);
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
        Schema::dropIfExists('mst_pegawai');
    }
}
