<?php

namespace App\Services;

use App\Models\detail_jasa;
use Illuminate\Support\Facades\Log;

class DetailJasaService {
    public function getFirstJasa(int $invoice_id ) {
        $jasa = detail_jasa::on()->where('invoice_id', $invoice_id)->first();
        return $jasa;
    }
    public function insertJasa(int $invoice_id, int $jasa_id) {
        $detailJasa = new detail_jasa();
        $detailJasa->invoice_id = $invoice_id;
        $detailJasa->jasa_id = $jasa_id;
        $detailJasa->save();
    }

    public function updateNomorKandang(int $invoice_id, int $nomor_kandang) {
        $detailJasa = detail_jasa::on()->where('invoice_id', $invoice_id)->first();
        if ($detailJasa) {
            $detailJasa->nomor_kandang = $nomor_kandang;
            $detailJasa->save();
        } else {
            Log::error("No detail_jasa found for invoice_id: $invoice_id");
        }
    }
}
