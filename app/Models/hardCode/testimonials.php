<?php

namespace App\Models\hardCode;


class Testimonials
{
    private static $testimonials = [
        [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum sunt placeat atque tenetur voluptas dolorem molestias quis? Sint vel voluptate sequi.',
            'author' => 'John Doe',
        ],
        [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur ea at adipisci dicta possimus eligendi recusandae molestiae iste quos blanditiis dolores amet, exercitationem soluta quia.',
            'author' => 'Jane Doe',
        ],
        [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum sunt placeat atque tenetur voluptas dolorem molestias quis?.',
            'author' => 'James Doe',
        ],
        [
            'title' => 'Lorem Ipsum',
            'description' => 'LoremLorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur ea at adipisci dicta possimus eligendi recusandae molestiae iste quos blanditiis dolores amet, exercitationem.',
            'author' => 'Jacob Doe',
        ]
    ];
    public static function getAllTestimonials()
    {
        return self::$testimonials;
    }
}
