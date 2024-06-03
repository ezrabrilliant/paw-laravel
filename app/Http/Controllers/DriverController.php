<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use App\Services\StatusOrderanService;
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

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = Carbon::now()->toDateString();
        //cek status orderan 
        foreach ($invoices as $invoice) {
            $statusOrderan = $this->statusOrderanService->getStatus($invoice->invoice_id);
            $statusOrderan = $this->statusOrderanService->checkStatus($statusOrderan);
            Log::info($invoice);
            if($statusOrderan == 'Order Submitted'){
                Log::info('order submitted' . $invoice);
                if($invoice->tanggal_masuk == $currentDate){
                    $invoice->layanan = 'Jemput';
                    Log::info('same date' . $invoice);
                }
            } else if($statusOrderan == 'Hewan Sudah Masuk Toko'){
                Log::info('masuk toko' . $invoice);
                if($invoice->tanggal_keluar == $currentDate){
                    $invoice->layanan = 'Antar';
                    Log::info('same date' . $invoice);
                }
            }
        }
        $filteredInvoices = $invoices->filter(function($invoice) {
            return !is_null($invoice->layanan);
        });
    return view('admin.driver', compact('filteredInvoices'));
    }

    public function updatePesanan(Request $request){
        $validatedData = $request->validate([
            'invoice_id' => 'required|int',
            'layanan' => 'required|string',
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
