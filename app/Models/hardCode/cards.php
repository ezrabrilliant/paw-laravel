<?php

namespace App\Models\hardCode;

class cards
{
    private static $cards = [
        [
            'image' => 'images/dog2.jpg',
            'title' => 'Jasa Penitipan',
            'description' => 'Melayanan Penitipan Anjing dengan Cinta dan Perhatian. ',
            'link' => 'penitipan',
        ],

        [
            'image' => 'images/dog3.jpg',
            'title' => 'Jasa Grooming',
            'description' => 'Menyediakan semua layanan perawatan hewan peliharaan. ',
            'link' => 'grooming',
        ],

        [
            'image' => 'images/dog4.jpg',
            'title' => 'Konsultasi Peliharaan',
            'description' => 'layanan perawatan hewan peliharaan terbaik. ',
            'link' => 'konsultasi',
        ]
    ];

    public static function getAllCards()
    {
        return self::$cards;
    }
}
