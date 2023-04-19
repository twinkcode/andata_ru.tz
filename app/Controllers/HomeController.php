<?php

namespace App\Controllers;

use App\Models\Comment;
use Faker\Factory;
use Faker\Generator;

class HomeController
{
    /**
     * Отображает главную страницу приложения.
     *
     * @return bool|string
     */
    public function index(): bool|string
    {
        /** @var Generator $faker */
        $faker = Factory::create('ru_RU');

        $comments = Comment::all();

        return view('home', [
            'comments' => $comments,
            'title' => $faker->text(85),
            'paragraphs' => [
                $faker->realText(500),
                $faker->realText(700),
            ],
        ]);
    }
}
