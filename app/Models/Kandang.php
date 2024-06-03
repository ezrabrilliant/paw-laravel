<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    //nomor_kandang
    use HasFactory;

    protected $primaryKey = 'nomor_kandang';
    protected $connection = 'mysql';
    protected $table = 'kandang';
    public $timestamps = false;
}
