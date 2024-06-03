<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;

class LihatListOrderController extends Controller
{
    public function index()
    {
        $InvoiceService = new InvoiceService();
        $invoices = $InvoiceService->getInvoicebyUser(Auth::user()->member_id);
        return view('pages.LihatListOrderUI', compact('invoices'));
    }
}
