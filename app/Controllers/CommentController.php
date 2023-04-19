<?php

namespace App\Controllers;

use App\Models\Comment;

/**
 * Class CommentController
 *
 * Контроллер для управления комментариями.
 */
class CommentController
{
    /**
     * Возвращает список всех комментариев в формате JSON.
     *
     * @return void
     */
    public function index(): void
    {
        $comments = Comment::all();
        $json = json_encode($comments, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json');
        exit($json);
    }

    /**
     * Создает новый комментарий на основе входных данных POST-запроса.
     *
     * @return void
     */
    public function create(): void
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['title']) && isset($_POST['text'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $title = trim($_POST['title']);
            $text = trim($_POST['text']);

            $comment = new Comment($name, $email , $title, $text);

            $result = $comment->save();
            header('Content-Type: application/json');
            $json = json_encode($result, JSON_UNESCAPED_UNICODE);
            echo $json;
            exit();
        }
    }
}
