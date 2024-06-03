<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function penitipan()
    {
        return view('order.penitipan');
    }

    public function whatsapp()
    {
        return view('components.whatsapp');
    }
}
