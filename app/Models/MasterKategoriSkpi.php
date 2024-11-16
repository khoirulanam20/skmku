<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKategoriSkpi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kategori',
       
    ];
    public function unsurs()
{
    return $this->hasMany(MasterUnsurSkpi::class, 'kategori_id');
}
}

