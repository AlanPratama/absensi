<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPOI extends Model
{
    use HasFactory;

    protected $table = 'detail_poi';
    protected $guarded = ['id'];

    public function POI() {
        return $this->belongsTo(POI::class, 'poi_id', 'id');
    }
}
