<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kecamatan_id',
        'name',
    ];

    // Specify the primary key
    protected $primaryKey = 'kecamatan_id';

    // Disable auto-incrementing (since it's not an integer)
    public $incrementing = false;

    // Set the type of the primary key to string
    protected $keyType = 'string';
}
