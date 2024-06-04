<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    protected $invoiceService;
    protected $statusOrderanService;
    public function __construct(
        InvoiceService $invoiceService,
        StatusOrderanService $statusOrderanService,
    ) {
        $this->invoiceService = $invoiceService;
        $this->statusOrderanService = $statusOrderanService;
    }
    public function driver()
    {
        $invoices = $this->invoiceService->getInvoicebyDelivery();

        // 'Order Submitted'; $status_orderan =  -1 //done important checkin
        // 'Telah Mendapatkan Driver'; $status_orderan =  0 //done
        // 'Driver Sudah Sampai di tujuan'; $status_orderan =  1 //done
        // 'Hewan Sudah dijemput Driver'; $status_orderan =  2 //done important check in
        // 'Hewan Sudah Masuk Toko'; $status_orderan =  3 //done important checkout Antar (admin)
        // 'Hewan Sudah Keluar Toko'; $status_orderan =  4 //done (driver)
        // 'Hewan Sedang diantar Driver'; $status_orderan =  5 //same (driver)
        // 'Driver Sampai di tujuan'; $status_orderan =  6 //same (driver)
        // 'Pesanan Selesai'; $status_orderan =  8 //done
        // 'Pesanan Didenda'; $status_orderan =  9
        // 'Pesanan dicancel'; $status_orderan =  10 //done

        //cek status orderan
        foreach ($invoices as $invoice) {
            $statusOrderan = $this->statusOrderanService->getStatus($invoice->invoice_id);
            $statusOrderan = $this->statusOrderanService->checkStatus($statusOrderan);

            //jemput
            if ($statusOrderan == 'Order Submitted' && $this->cektanggal($invoice->tanggal_masuk)) {
                Log::info('masuk');
                $this->setInvoiceProperties(0, $invoice, 'Jemput', $statusOrderan, $invoice->tanggal_masuk, 'Jemput Pesanan ini');
            }else if ($statusOrderan == 'Telah Mendapatkan Driver') {
                $this->setInvoiceProperties(1, $invoice, 'Jemput', $statusOrderan, $invoice->tanggal_masuk, 'Sudah sampai tujuan jemput');
            } else if ($statusOrderan == 'Driver Sudah Sampai di tujuan') {
                $this->setInvoiceProperties(2, $invoice, 'Jemput', $statusOrderan, $invoice->tanggal_masuk, 'Hewan Sudah dijemput');
            } else if ($statusOrderan == 'Hewan Sudah dijemput Driver') {
                $this->setInvoiceProperties(null, $invoice, 'Jemput', $statusOrderan, $invoice->tanggal_masuk, 'Disabled');
            }

            //antar
            else if ($statusOrderan == 'Hewan Sudah Masuk Toko' && $this->cektanggal($invoice->tanggal_keluar)) {
                $this->setInvoiceProperties(4, $invoice, 'Antar', $statusOrderan, $invoice->tanggal_keluar, 'Antar Pesanan ini');
            } else if ($statusOrderan == 'Hewan Sudah Keluar Toko') {
                $this->setInvoiceProperties(5, $invoice, 'Antar', $statusOrderan, $invoice->tanggal_keluar, 'Hewan sedang diantar');
            } else if ($statusOrderan == 'Hewan Sedang diantar Driver') {
                $this->setInvoiceProperties(6, $invoice, 'Antar', $statusOrderan, $invoice->tanggal_keluar, 'sudah sampai tujuan antar');
            } else if ($statusOrderan == 'Driver Sampai di tujuan') {
                $this->setInvoiceProperties(8, $invoice, 'Antar', $statusOrderan, $invoice->tanggal_keluar, 'Pesanan Selesai');
            }
        }
        $filteredInvoices = $invoices->filter(function($invoice) {
            return !is_null($invoice->layanan);
        });
    return view('admin.driver', compact('filteredInvoices'));
    }

    private function setInvoiceProperties($newStatus, $invoice, $layanan, $statusText, $tanggal, $button) {
        $invoice->newStatus = $newStatus;
        $invoice->layanan = $layanan;
        $invoice->statusText = $statusText;
        $invoice->tanggal = $tanggal;
        $invoice->button = $button;
    }

    public function cekTanggal($tanggal){
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = Carbon::now()->toDateString();
        if($tanggal == $currentDate){
            return true;
        } else return false;
    }

    public function updatePesanan(Request $request){
        $validatedData = $request->validate([
            'invoice_id' => 'required|int',
            'newStatus' => 'required|int',
        ]);

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $invoice_id = $validatedData['invoice_id'];
        $layanan = $validatedData['layanan'];
        if ($layanan == 'Jemput') {
            $this->statusOrderanService->insertStatuswithDriver($invoice_id, 0, Auth::user()->member_id, Carbon::now());
        } else if ($layanan == 'Antar') {
            $this->statusOrderanService->insertStatuswithDriver($invoice_id, 4, Auth::user()->member_id, Carbon::now());
            return response()->json(['success' => 'Pesanan telah dikirim.'], 200);
        } else return response()->json(['error' => 'Invalid layanan.'], 400);
    }
}
