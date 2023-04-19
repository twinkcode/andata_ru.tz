<?php

/**
 * Отображает шаблон с переданными данными.
 *
 * @param string $view Имя файла шаблона без расширения `.php`.
 * @param array $data Массив данных для передачи в шаблон.
 * @return string Содержимое шаблона, преобразованное в строку.
 */
function view(string $view, array $data = []): string
{
    extract($data);

    ob_start();
    include_once("Views/{$view}.php");
    $content = ob_get_contents();
    ob_end_clean();

    echo $content;
    return $content;
}
