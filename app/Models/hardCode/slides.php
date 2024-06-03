<?php

namespace App\Models\hardCode;

class slides
{
    private static $slides = [
        [
            'image' => 'images/dog-bg-3.jpg',
            'title' => 'Jasa Penitipan',
            'description' => 'We provide top-notch care for your furry friends. Whether it\'s grooming or boarding, your pet is in safe hands',
            'link' => 'penitipan',
        ],
        [
            'image' => 'images/dog-bg.jpg',
            'title' => 'Jasa Grooming',
            'description' => 'We provide top-notch care for your furry friends. Whether it\'s grooming or boarding, your pet is in safe hands',
            'link' => 'grooming',
        ],
        [
            'image' => 'images/dog-bg-2.jpg',
            'title' => 'Konsultasi Peliharaan',
            'description' => 'We provide top-notch care for your furry friends. Whether it\'s grooming or boarding, your pet is in safe hands',
            'link' => 'konsultasi',
        ],
    ];
    public static function getAllSlides()
    {
        return self::$slides;
    }
}
