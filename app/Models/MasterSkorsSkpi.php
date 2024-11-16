<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSkorsSkpi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sub_unsur',
        'nama_tingkat',
        'skor',
        'unsur_id',
       
    ];
    public function unsur()
    {
        return $this->belongsTo(MasterUnsurSkpi::class);
    }
}
