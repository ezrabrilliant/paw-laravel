<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_jasa extends Model
{
    use HasFactory;
    // invoice_id, jasa_id, nomor_kandang
    protected $primaryKey = 'invoice_id';
    protected $connection = 'mysql';
    protected $table = 'detail_jasa';
    public $timestamps = false;
}
