<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService {
    public function getInvoicebyUser(int $user) {
        $invoices = Invoice::on()->where('member_id', $user)->get();
        return $invoices;
    }
    public function getInvoicebyId(int $invoice_Id) {
        $invoice = Invoice::where('invoice_id', $invoice_Id)->first();
        return $invoice;
    }
    public function getInvoicebyDelivery() {
        $invoices = Invoice::where('harga_delivery', '!=', 0)->get();
        return $invoices;
    }
    public function hitungDenda(int $days, int $hargaDenda) {
        $denda = $days * $hargaDenda;
        return $denda;
    }
}
