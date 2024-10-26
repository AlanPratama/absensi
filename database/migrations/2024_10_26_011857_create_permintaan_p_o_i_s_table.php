<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanPOISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_poi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("pegawai_id");
            $table->foreign("pegawai_id")->references("id")->on("users")->onDelete("cascade");

            $table->unsignedBigInteger("poi_id");
            $table->foreign("poi_id")->references("id")->on("pois")->onDelete("cascade");

            $table->date('tanggal');

            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->nullable()->default('Pending');

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
        Schema::dropIfExists('permintaan_poi');
    }
}
