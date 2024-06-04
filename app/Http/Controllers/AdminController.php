<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Services\StatusOrderanService;
use App\Services\DetailJasaService;
use App\Services\LihatListJasaService;
use App\Services\KandangService;
use App\Services\OrderJasaService;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $invoiceService;
    protected $statusOrderanService;
    protected $detailJasaService;
    protected $lihatListJasaService;
    protected $kandangService;
    protected $orderJasaService;

    public function __construct(
        InvoiceService $invoiceService,
        StatusOrderanService $statusOrderanService,
        DetailJasaService $detailJasaService,
        LihatListJasaService $lihatListJasaService,
        KandangService $kandangService,
        OrderJasaService $orderJasaService
    ) {
        $this->invoiceService = $invoiceService;
        $this->statusOrderanService = $statusOrderanService;
        $this->detailJasaService = $detailJasaService;
        $this->lihatListJasaService = $lihatListJasaService;
        $this->kandangService = $kandangService;
        $this->orderJasaService = $orderJasaService;
    }

    public function admin()
    {
        return view('admin/admin');
    }

    public function search(Request $request)
    {
        Log::info('function search called');
        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
        ]);

        $invoice_id = $validatedData['invoice_id'];
        $invoice = $this->invoiceService->getInvoiceById($invoice_id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found.'], 404);
        }

        $statusOrderan = $this->statusOrderanService->getStatus($invoice_id);
        $statusOrderan = $this->statusOrderanService->checkStatus($statusOrderan);

        $detailJasa = $this->detailJasaService->getFirstJasa($invoice_id);
        $jenisJasa = $this->lihatListJasaService->cekGroomingOrPenitipan($detailJasa->jasa_id);

        return response()->json([
            'invoice_id' => $invoice->invoice_id,
            'nama_hewan' => $invoice->nama_hewan,
            'harga_delivery' => $invoice->harga_delivery,
            'status' => $statusOrderan,
            'tanggal_masuk' => $invoice->tanggal_masuk,
            'tanggal_keluar' => $invoice->tanggal_keluar,
            'jenis_jasa' => $jenisJasa,
        ]);
    }

    public function cekTanggalMasuk($invoiceId)
    {
        Log::info('function cekTanggalMasuk called');
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = Carbon::now()->toDateString();

        if ($invoice->tanggal_masuk == $currentDate) {
            return ['status' => 1, 'message' => 'Pesanan sukses diproses', 'denda' => 0];
        } elseif ($invoice->tanggal_masuk < $currentDate) {
            return ['status' => -1, 'message' => 'Pesanan melebihi waktu yang dipesan oleh member', 'denda' => 0];
        } else {
            return ['status' => 0, 'message' => 'Pesanan tidak dapat diproses karena belum waktunya', 'denda' => 0];
        }
    }

    public function cekTanggalKeluar($invoiceId)
    {
        Log::info('function cekTanggal called');
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = Carbon::now()->toDateString();

        if ($invoice->tanggal_keluar == $currentDate) {
            return ['status' => 1, 'message' => 'Pesanan sukses diproses'];
        } elseif ($invoice->tanggal_keluar < $currentDate) {
            $days = $this->orderJasaService->hitungHari($invoice->tanggal_keluar, $currentDate);
            $denda = $this->lihatListJasaService->getHargaJasa([$invoice->jasa_id]);
            $hargaDenda = $this->invoiceService->hitungDenda($days, $denda);
            Log::info($hargaDenda);
            return ['status' => 0, 'message' => 'Customer melebihi batas checkout','denda' => $hargaDenda];
        } else {
            return ['status' => 0, 'message' => 'Pesanan tidak dapat diproses karena belum waktunya','denda' => 0];
        }
    }

    public function cekStatus(Request $request)
    {
        Log::info('function cekStatus called');
        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $invoice = $this->invoiceService->getInvoiceById($validatedData['invoice_id']);
        $statusOrderan = $validatedData['status'];

        $statusOnDriver = [
            'Telah Mendapatkan Driver',
            'Driver Sudah Sampai di tujuan',
            'Hewan Sudah Keluar Toko',
            'Hewan Sedang diantar Driver',
            'Driver Sampai di tujuan'
        ];

        if ($statusOrderan == 'Order Submitted' || $statusOrderan == 'Hewan Sudah dijemput Driver') {
            return response()->json([
                'state_check' => 'Check In',
                'newStatus' => 3,
            ]);
        } else if ($statusOrderan == 'Hewan Sudah Masuk Toko') {
            return response()->json([
                'state_check' => 'Check Out',
                'newStatus' => 8,
            ]);
        } else if ($statusOrderan == 'Hewan Sudah Keluar Toko') {
            return response()->json([
                'state_check' => 'Check Out',
                'newStatus' => 5,
            ]);
        } else if ($statusOrderan == 'Pesanan Selesai') {
            return response()->json([
                'error' => 'Pesanan Sudah Selesai.'
            ]);
        } else if ($statusOrderan == 'Pesanan dicancel') {
            return response()->json([
                'error' => 'Pesanan Sudah dicancel.'
            ]);
        } else if ($statusOrderan == 'Pesanan Didenda') {
            Carbon::setLocale('id');
            $currentDate = Carbon::now()->toDateString();
            $days = $this->orderJasaService->hitungHari($invoice->tanggal_keluar, $currentDate);
            $denda = $this->lihatListJasaService->getHargaJasa([$invoice->jasa_id]);
            $hargaDenda = $this->invoiceService->hitungDenda($days, $denda);
            return response()->json([
                'denda' => $hargaDenda,
            ]);
        } else if (in_array($statusOrderan, $statusOnDriver)) {
            return response()->json([
                'error' => 'Hewan sedang dalam perjalanan dengan Driver.'
            ]);
        }

        else {
            return response()->json(['error' => 'Status not found.']);
        }
    }

    public function cekTanggal(Request $request){
        Log::info('function cekTanggal called');
        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
            'state_check' => 'required|string',
        ]);

        $cekStatus = $validatedData['state_check'];

        if ($cekStatus == 'Check In') {
            $cekTanggalMasuk = $this->cekTanggalMasuk($validatedData['invoice_id']);
            return response()->json([
                'status' => $cekTanggalMasuk['status'],
                'message' => $cekTanggalMasuk['message'],
                'denda' => $cekTanggalMasuk['denda'],
            ]);
        } else if($cekStatus == 'Check Out') {
            $cekTanggalKeluar = $this->cekTanggalKeluar($validatedData['invoice_id']);
            return response()->json([
                'status' => $cekTanggalKeluar['status'],
                'message' => $cekTanggalKeluar['message'],
                'denda' => $cekTanggalKeluar['denda'],
            ]);
        } else {
            return response()->json(['error' => $cekStatus['message']]);
        }
    }

    public function insertStatus(Request $request)
    {
        Log::info('function insertStatus called');

        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
            'newStatus' => 'required|integer',
        ]);

        $invoice_id = $validatedData['invoice_id'];
        $newStatus = $validatedData['newStatus'];

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        Log::info($validatedData['invoice_id']);
        Log::info($newStatus);

        if($newStatus == 8){
            $detailJasa = $this->detailJasaService->getFirstJasa($invoice_id);
            $jenisJasa = $this->lihatListJasaService->cekGroomingOrPenitipan($detailJasa->jasa_id);
            Log::info('status 8');
            Log::info($jenisJasa);
            if($jenisJasa == 'penitipan'){
                $nomor_kandang = $this->kandangService->findKandang($validatedData['invoice_id']);
                $this->kandangService->updateAvailableTrue($nomor_kandang);
                return response()->json(['message' => 'Kandang berhasil dilepas.']);
            }
        }

        $this->statusOrderanService->insertStatus($invoice_id, $newStatus, Carbon::now());
        return response()->json(['message' => 'Status berhasil diubah.']);
    }

    public function saveCageNumber(Request $request)
    {
        Log::info('function saveCageNumber called');
        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
            'cage_number' => 'required|integer',
        ]);
        $invoiceId = $validatedData['invoice_id'];
        $cageNumber = $validatedData['cage_number'];

        $kandangService = new KandangService();
        $checkAvailable = $kandangService->checkAvailable($cageNumber);

        if (!$checkAvailable) {
            return response()->json(['error' => 'Cage number is not available.', 'checkCage' => 0]);
        } else {
            $kandangService->updateAvailable($cageNumber);
            $detailJasaService = new DetailJasaService();
            $detailJasaService->updateNomorKandang($invoiceId, $cageNumber);

            return response()->json(['message' => 'Cage number updated successfully.', 'checkCage' => 1]);
        }
    }

    public function PaidDenda(Request $request)
    {
        Log::info('function PaidDenda called');
        $validatedData = $request->validate([
            'invoice_id' => 'required|integer',
        ]);

        $invoiceId = $validatedData['invoice_id'];
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);
        $denda = $invoice->denda;

        $this->statusOrderanService->insertStatus($validatedData['invoice_id'], 8, Carbon::now());
        return response()->json(['message' => 'Denda berhasil dibayar.']);
    }
}
