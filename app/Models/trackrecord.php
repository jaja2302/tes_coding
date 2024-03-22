<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trackrecord extends Model
{
    use HasFactory;
    protected $table = 'record';

    protected $fillable = [
        'klub',
        'ma',
        'me',
        's',
        'k',
        'gm',
        'gk',
        'point'
    ];

    public $timestamps = false;
}
