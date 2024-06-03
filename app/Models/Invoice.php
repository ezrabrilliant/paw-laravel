<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //invoice_id, nama_hewan, umur, weight, tanggal_masuk, tanggal_keluar, alamat, harga_delivery, member_id
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'invoice';
    public $timestamps = false;
}
