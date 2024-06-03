<?php

namespace App\Services;

use App\Models\Invoice;
use App\Services\DetailJasaService;
use App\Services\LihatListJasaService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class OrderJasaService {
    public function insertOrderJasa(string $nama_hewan, int $umur, int $weight, string $tanggal_masuk, string $tanggal_keluar, string $address, int $harga_delivery, int $member_id, array $jasa_ids) {
        $invoice = new Invoice();
        $invoice->nama_hewan = $nama_hewan;
        $invoice->umur = $umur;
        $invoice->weight = $weight;
        $invoice->tanggal_masuk = $tanggal_masuk;
        $invoice->tanggal_keluar = $tanggal_keluar;
        $invoice->alamat = $address;
        $invoice->harga_delivery = $harga_delivery;
        $invoice->member_id = $member_id;
        $invoice->save();

        $detailJasaService = new DetailJasaService();
        $statusOrderanService = new StatusOrderanService();
        if ($invoice) {
            foreach ($jasa_ids as $jasa_id) {
                $detailJasaService->insertJasa($invoice->id, $jasa_id);
                $statusOrderanService->insertStatus($invoice->id, -1, Carbon::now());
            }
        }
    }
    public function hitungBiayaDelivery(string $address) {
        $api_key = env('API_GOOGLE_MAPS_KEY');
        $paw_address = "Universitas Kristen Petra";

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . urlencode($address) . "&destinations=" . urlencode($paw_address) . "&key=" . $api_key;

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $result_km = 0;
        if(isset($data['rows'][0]['elements'][0]['distance']['value'])) {
            $result_km = $data['rows'][0]['elements'][0]['distance']['value'] / 1000;
        } else {
            return null;
        }

        $tarif_per_km = 3000;
        $harga_delivery = $result_km * $tarif_per_km;
        if ($harga_delivery > $tarif_per_km * 20) {
            $harga_delivery = -1;
        }

        if ($harga_delivery < 10000) {
            $harga_delivery = 10000;
        } else {
            $harga_delivery = round($harga_delivery, -3);
            $harga_delivery = $harga_delivery*2;
        }
        return $harga_delivery;
    }
    public function countHargaJasa(array $jasa_ids) {
        $totalHarga = 0;
        $lihatListJasaService = new LihatListJasaService();

        foreach ($jasa_ids as $jasa_id) {
            $hargaJasa =  $lihatListJasaService->getHargaJasa([$jasa_id]);
            $totalHarga += $hargaJasa;
        }

        return $totalHarga;
    }

    public function hitungHari(string $tanggal_masuk, string $tanggal_keluar) {
        $date1 = date_create($tanggal_masuk);
        $date2 = date_create($tanggal_keluar);
        $diff = date_diff($date1, $date2);
        $days = $diff->days;
        return $days;
    }
    public function hitungBiayaPenitipan(int $days, int $jasa_id) {
        $lihatListJasaService = new LihatListJasaService();
        $harga_jasa = $days * $lihatListJasaService->getHargaJasaById($jasa_id);
        return $harga_jasa;
    }

    public function addTotalHargaDeliveryToSubtotal(int $totalCost, int $harga_delivery) {
        return $totalCost + $harga_delivery;
    }

    public function addTotalHargaJasaToSubtotal(int $totalCost, int $harga_jasa) {
        return $totalCost + $harga_jasa;
    }
}
