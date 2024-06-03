<?php

namespace App\Http\Controllers;

use App\Services\LihatListJasaService;

class JasaController extends Controller
{
    public function index()
    {
        $lihatListJasaService = new LihatListJasaService();
        $jasas = $lihatListJasaService->getGroomingJasa();
        return view('order.grooming', compact('jasas'));
    }
}
