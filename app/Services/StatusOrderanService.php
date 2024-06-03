<?php

namespace App\Services;

use App\Models\status_orderan;
class StatusOrderanService {
    public function insertStatus(int $invoice_id, int $status_orderan, string $timestamp) {
        $statusOrderan = new status_orderan();
        $statusOrderan->invoice_id = $invoice_id;
        $statusOrderan->status_orderan = $status_orderan;
        $statusOrderan->timestamp = $timestamp;
        $statusOrderan->save();
    }
    public function insertStatuswithDriver(int $invoice_id, int $driverId, int $status_orderan, string $timestamp) {
        $statusOrderan = new status_orderan();
        $statusOrderan->invoice_id = $invoice_id;
        $statusOrderan->driver_id = $driverId;
        $statusOrderan->status_orderan = $status_orderan;
        $statusOrderan->timestamp = $timestamp;
        $statusOrderan->save();
    }

    // status_orderan: invoice_id, member_id, status_orderan, timestamp
    //get only status_orderan
    public function getStatus(int $invoice_id ) {
        $records = status_orderan::where('invoice_id', $invoice_id)
        ->orderBy('timestamp', 'desc')
        ->orderBy('status_orderan', 'desc')
        ->get()
        ->value('status_orderan');
        return $records;
    }

    public function getTimestamp(int $status_orderan) {
        $timestamp = status_orderan::where('status_orderan', $status_orderan)->value('timestamp');
        return $timestamp;
    }
    public function checkStatus(int $status_orderan) {
        if ($status_orderan == -1) {
            return 'Order Submitted';
        } else if ($status_orderan == 0) {
            return 'Telah Mendapatkan Driver';
        } else if ($status_orderan == 1) {
            return 'Driver Sudah Sampai di tujuan';
        } else if ($status_orderan == 2) {
            return 'Hewan Sudah dijemput Driver';
        } else if ($status_orderan == 3) {
            return 'Hewan Sudah Masuk Toko';
        } else if ($status_orderan == 4) {
            return 'Hewan Sudah Keluar Toko';
        } else if ($status_orderan == 5) {
            return 'Hewan Sedang diantar Driver';
        } else if ($status_orderan == 6) {
            return 'Driver Sampai di tujuan';
        } else if ($status_orderan == 8) {
            return 'Pesanan Selesai';
        } else if ($status_orderan == 9) {
            return 'Pesanan Didenda';
        } else if ($status_orderan == 10) {
            return 'Pesanan dicancel';
        }
    }
}
