<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUnsurSkpi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_unsur',
        'kategori_id',

    ];
    public function kategori()
    {
        return $this->belongsTo(MasterKategoriSkpi::class);
    }
    public function skors()
    {
        return $this->hasMany(MasterSkorsSkpi::class, 'unsur_id');
    }
}
