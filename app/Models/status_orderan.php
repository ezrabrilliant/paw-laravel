<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_orderan extends Model
{
    // invoice_id, member_id, status_orderan, timestamp

    //-1: order submitted (user yg mesen)
    // 0: telah mendapatkan driver  (driver)
    // 1: driver sampai di rumah pemilik (driver)
    // 2: hewan sudah dijemput driver (driver)
    // 3: hewan sudah masuk toko (adm toko)
    // 4: hewan sudah keluar toko (driver)
    // 5: hewan sedang diantar driver (driver)
    // 6: driver sampai di rumah pemilik (driver)
    // 8: pesanan selesai (driver & adm toko)
    // 10: pesanan dicancel
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'status_orderan';
    public $timestamps = false;
}


