<?php

namespace App\Http\Controllers;

use App\Models\hardCode\Slides;
use App\Models\hardCode\Cards;
use App\Models\hardCode\Testimonials;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slides::getAllSlides();
        $cards = Cards::getAllCards();
        $testimoni = Testimonials::getAllTestimonials();
        return view('pages.home', compact('slides', 'cards', 'testimoni'));
    }
}
