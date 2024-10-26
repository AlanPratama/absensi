<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPOISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_poi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("pegawai_id")->nullable();
            $table->foreign("pegawai_id")->references("id")->on("users")->onDelete("set null");

            $table->unsignedBigInteger("poi_id");
            $table->foreign("poi_id")->references("id")->on("pois")->onDelete("cascade");

            $table->text('pesan');
            $table->string('foto')->nullable();

            $table->enum('tipe_tanda_tangan', ['Pegawai', 'Pelanggan']);

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
        Schema::dropIfExists('detail_poi');
    }
}
