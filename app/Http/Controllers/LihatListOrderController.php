<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderJasaService;
use App\Services\DetailJasaService;
use Illuminate\Support\Facades\Log;

class LihatListOrderController extends Controller
{
    public function index()
    {
        $invoiceService = new InvoiceService();
        $invoices = $invoiceService->getInvoicebyUser(Auth::user()->member_id);

        $detailJasaService = new DetailJasaService();
        $orderJasaService = new OrderJasaService();

        $serviceCost = 0;
        $totalCost = 0;

        foreach ($invoices as $invoice) {
            $OrderJasaService = new OrderJasaService();
            $harga = $OrderJasaService->countHargabyInvoiceId($invoice->invoice_id);

            $invoice->serviceCost = $harga;
            $jasaid = [];
            $harga = 0;
        }

        return view('pages.LihatListOrderUI', compact('invoices'));
    }
}
