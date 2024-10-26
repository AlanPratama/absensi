<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POI extends Model
{
    use HasFactory;

    protected $table = 'pois';
    protected $guarded = ['id'];

    public function Pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }

    public function Pegawai() {
        return $this->belongsTo(User::class, 'pegawai_id', 'id');
    }

    public function KategoriPOI() {
        return $this->belongsTo(KategoriPOI::class, 'kategori_poi_id', 'id');
    }

    public function DetailPOI() {
        return $this->hasMany(DetailPOI::class, 'poi_id', 'id');
    }

    public function PermintaanPOI() {
        return $this->hasMany(PermintaanPOI::class, 'poi_id', 'id');
    }
}
