<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'products_buku';

    protected $primaryKey = 'idBuku';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'idBuku',
        'judul',
        'authors',
        'thnTerbit',
        'stok'
    ];
}
