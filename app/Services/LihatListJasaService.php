<?php

namespace App\Services;

use App\Models\Jasa;

class LihatListJasaService {
    public function getHargaJasa(array $jasa_ids) {
        $totalHarga = 0;

        foreach ($jasa_ids as $jasa_id) {
            $hargaJasa = $this->getHargaJasaById($jasa_id);
            $totalHarga += $hargaJasa;
        }

        return $totalHarga;
    }

    public function getHargaJasaById(int $jasa_id) {

        $hargaJasa = Jasa::where('jasa_id', $jasa_id)->value('harga');
        return $hargaJasa;
    }

    public function getGroomingJasa() {
        $jasaGrooming = Jasa::where('grooming_product', 1)->get();

        return $jasaGrooming;
    }

    public function cekGroomingorPenitipan(int $jasa_id) {
        $jasa = Jasa::where('jasa_id', $jasa_id)->first();
        if ($jasa->grooming_product == 1) {
            return 'grooming';
        }
        if ($jasa->penitipan_product == 1){
            return 'penitipan';
        }
    }




}
