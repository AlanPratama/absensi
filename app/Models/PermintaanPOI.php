<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPOI extends Model
{
    use HasFactory;

    protected $table = 'permintaan_poi';
    protected $guarded = ['id'];

    public function Pegawai() {
        return $this->belongsTo(User::class, 'pegawai_id', 'id');
    }

    public function POI() {
        return $this->belongsTo(POI::class, 'poi_id', 'id');
    }
}
