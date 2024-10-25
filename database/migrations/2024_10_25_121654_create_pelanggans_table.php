<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();

            $table->string('no_telepon_pic')->nullable();

            $table->enum('tipe', ['Perorangan', 'Perusahaan', 'Toko', 'Lainnya'])->default('Lainnya');

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
        Schema::dropIfExists('pelanggans');
    }
}
