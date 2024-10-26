<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPOI extends Model
{
    use HasFactory;

    protected $table = 'kategori_poi';
    protected $guarded = ['id'];

    public function POI() {
        return $this->hasMany(POI::class, 'kategori_poi_id', 'id');
    }
}
