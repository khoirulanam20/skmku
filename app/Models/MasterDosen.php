<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDosen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nidn',
        'alamat',
        'telepon',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
