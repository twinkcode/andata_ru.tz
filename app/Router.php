<?php
namespace App;

/**
 * Класс-маршрутизатор для обработки запросов к приложению.
 */
class Router
{
    /**
     * Массив маршрутов, где ключ - HTTP-метод, значение - массив маршрутов для этого метода.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Регистрирует маршрут для HTTP-метода GET.
     *
     * @param string $path URL-путь для маршрута.
     * @param string $controller Имя контроллера и метода, разделенные символом "@".
     * @return void
     */
    public function get(string $path, string $controller): void
    {
        $this->routes['GET'][$path] = $controller;
    }

    /**
     * Регистрирует маршрут для HTTP-метода POST.
     *
     * @param string $path URL-путь для маршрута.
     * @param string $controller Имя контроллера и метода, разделенные символом "@".
     * @return void
     */
    public function post(string $path, string $controller): void
    {
        $this->routes['POST'][$path] = $controller;
    }

    /**
     * Обрабатывает запрос, соответствующий переданному URI и HTTP-методу.
     *
     * @param string $uri URI запроса.
     * @param string $method HTTP-метод.
     * @return void
     */
    public function handle(string $uri, string $method): void
    {
        if (!isset($this->routes[$method])) {
            header("HTTP/1.0 404 Not Found");
            die('Method' . $method . ' Not Found');
        }

        foreach ($this->routes[$method] as $path => $controller) {
            if ($path === $uri) {
                $this->callAction($controller);
                return;
            }
        }
    }

    /**
     * Вызывает метод контроллера, указанный в маршруте.
     *
     * @param string $controller Имя контроллера и метода, разделенные символом "@".
     * @return void
     */
    protected function callAction(string $controller): void
    {
        [$class, $method] = explode('@', $controller);

        $controller = new $class();
        $controller->$method();
    }
}
