<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Kandang;

class KandangService {
    //querry tabel kandang where nomor_kandang = $nomor_kandang, lalu update available = 0
    public function updateAvailable(int $nomor_kandang) {
        $kandang = Kandang::where('nomor_kandang', $nomor_kandang)->first();
        $kandang->available = 0;
        $kandang->save();
    }

    public function updateAvailableTrue(int $nomor_kandang) {
        //querry tabel kandang where nomor_kandang = $nomor_kandang, lalu update available = 1
        $kandang = Kandang::where('invoice_id', $nomor_kandang)->first();
        $kandang->available = 1;
        $kandang->save();
    }

    public function findKandang(int $invoice_id) {
        //querry tabel kandang where invoice_id = $invoice_id
        $kandang = Kandang::where('invoice_id', $invoice_id)->first()->value('nomor_kandang');
        return $kandang;
    }

    public function checkAvailable(int $nomor_kandang) {
        //querry tabel kandang where nomor_kandang = $nomor_kandang, cek apakah available = 1 atau 0
        $kandang = Kandang::where('nomor_kandang', $nomor_kandang)->first();
        if ($kandang->available == 1) {
            return true;
        } else {
            return false;
        }
    }
}
