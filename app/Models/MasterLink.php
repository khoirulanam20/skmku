<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'link',
       
    ];
}
