<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePOISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pois', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("pelanggan_id");
            $table->foreign("pelanggan_id")->references("id")->on("pelanggans")->onDelete("cascade");

            $table->unsignedBigInteger("pegawai_id")->nullable();
            $table->foreign("pegawai_id")->references("id")->on("users")->onDelete("set null");

            $table->unsignedBigInteger("kategori_poi_id")->nullable();
            $table->foreign("kategori_poi_id")->references("id")->on("kategori_poi")->onDelete("set null");

            $table->date('tanggal');
            $table->date('tanggal_mulai')->nullable();
            $table->boolean('terlambat')->nullable()->default(false);

            $table->string('target');

            // HANYA UNTUK QUANTITY
            $table->integer('jumlah_nominal')->nullable();
            $table->integer('nominal_akhir')->nullable();

            $table->string('lat_poi')->nullable();
            $table->string('long_poi')->nullable();
            $table->string('foto')->nullable();


            $table->enum('tipe', ['Kuantitas', 'Deskriptif']);
            $table->enum('status', ['Pending', 'In Progress', 'Done', 'Cancel'])->default('Pending');

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
        Schema::dropIfExists('pois');
    }
}
