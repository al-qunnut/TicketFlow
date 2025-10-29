<?php

class Router {
    private $twig;
    private $routes = [];
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (isset($this->routes[$method][$uri])) {
            return call_user_func($this->routes[$method][$uri]);
        }
        
        // Check for dynamic routes
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($callback, $matches);
            }
        }
        
        http_response_code(404);
        echo $this->twig->render('404.twig');
    }
    
    public function redirect($path) {
        header("Location: $path");
        exit;
    }
}
