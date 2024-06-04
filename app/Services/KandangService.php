<?php

namespace App\Services;

use App\Models\Kandang;
use App\Models\detail_jasa;

class KandangService {
    //querry tabel kandang where nomor_kandang = $nomor_kandang, lalu update available = 0
    public function updateAvailable(int $nomor_kandang) {
        $kandang = Kandang::where('nomor_kandang', $nomor_kandang)->first();
        $kandang->available = 0;
        $kandang->save();
    }

    public function updateAvailableTrue(int $nomor_kandang) {
        //querry tabel kandang where nomor_kandang = $nomor_kandang, lalu update available = 1
        $kandang = Kandang::where('nomor_kandang', $nomor_kandang)->first();
        $kandang->available = 1;
        $kandang->save();
    }

    public function findKandang(int $invoice_id) {
            //querry tabel detail_jasa where invoice_id = $invoice_id
        //querry tabel kandang where invoice_id = $invoice_id
        $detailJasa = detail_jasa::where('invoice_id', $invoice_id)->first();
        $kandang = Kandang::where('nomor_kandang', $detailJasa->nomor_kandang)->first();

        return $kandang->nomor_kandang;
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
