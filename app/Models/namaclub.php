<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class namaclub extends Model
{
    use HasFactory;

    protected $table = 'klub';

    protected $fillable = [
        'namaklub',
        'asalklub',
    ];
    public $timestamps = false;
}
