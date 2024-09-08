<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kelurahan_id',
        'name',
        'kecamatan_id',
    ];

    // Specify the primary key
    protected $primaryKey = 'kelurahan_id';

    // Disable auto-incrementing since it's not an integer
    public $incrementing = false;

    // Set the type of the primary key to string
    protected $keyType = 'string';

    // Define the relationship with the Kecamatan model
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'kecamatan_id');
    }
}
