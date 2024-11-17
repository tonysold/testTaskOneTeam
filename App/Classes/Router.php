<?php

namespace App\Classes;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->get('/', function () {
            require_once __DIR__ . '/../Views/WelcomePage.html';
        });


        $this->post('/upload', function () {
            require_once __DIR__ . '/../InputDataProcessing/upload.php';
        });

        $this->post('/insert', function () {
            require_once __DIR__ . '/../InputDataProcessing/insert.php';
        });

        $this->get('/paste', function () {
            require_once __DIR__ . '/../Classes/DataProcessing.php';
        });

        $this->post('/processing', function () {
            require_once __DIR__ . '/../Classes/DataProcessing.php';
        });
        $this->get('/processing', function () {
            require_once __DIR__ . '/../Classes/DataProcessing.php';
        });
    }

    public function addRoute($method, $url, $callback)
    {
        $method = strtoupper($method);
        $this->routes[$method][$url] = $callback;
    }

    public function get($url, $callback)
    {
        $this->addRoute('GET', $url, $callback);
    }


    public function post($url, $callback)
    {
        $this->addRoute('POST', $url, $callback);
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$url])) {
            call_user_func($this->routes[$method][$url]);
        } else {
            $this->notFound();
        }
    }

    private function notFound()
    {
        http_response_code(404);
        echo "Page not found";
    }

    public function run()
    {
        $this->handleRequest();
    }
}
