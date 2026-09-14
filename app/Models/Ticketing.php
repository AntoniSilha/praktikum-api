<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    protected $table = 'ticketing';

    protected $fillable = [
        'noAntrian',
        'layanan'
    ];
}
