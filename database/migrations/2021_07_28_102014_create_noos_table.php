<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nama_outlet');
            $table->text('alamat_outlet');
            $table->string('nama_pemilik_outlet');
            $table->string('nomer_tlp_outlet')->unique();
            $table->string('nomer_wakil_outlet');
            $table->string('ktp_outlet');
            $table->string('kota');
            $table->string('region');
            $table->foreignId('cluster_id');
            $table->string('poto_shop_sign');
            $table->string('poto_etalase');
            $table->string('poto_depan');
            $table->string('poto_kiri');
            $table->string('poto_kanan');
            $table->string('poto_belakang');
            $table->string('video');
            $table->string('oppo');
            $table->string('vivo');
            $table->string('realme');
            $table->string('samsung');
            $table->string('xiaomi');
            $table->string('fl');
            $table->string('latlong');
            $table->bigInteger('limit')->nullable();
            $table->string('status')->default('PENDING');
            $table->timestamp('rejected_at')->nullable();
            $table->string('rejected_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('noos');
    }
}
