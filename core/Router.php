<?php

class Router
{
    private array $routes = [];

    /**
     * Register a GET route
     * 
     * @param string $path URL path
     * @param string $action Controller action
     */
    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    /**
     * Register a POST route
     * 
     * @param string $path URL path
     * @param string $action Controller action
     */
    public function post(string $path, string $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    /**
     * Dispatch the request to the appropriate controller
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes[$method] ?? [] as $routePath => $action) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->executeAction($action, $params);
                return;
            }
        }

        $this->handleNotFound();
    }

    /**
     * Execute a controller action
     * 
     * @param string $action Format: "ControllerName@methodName"
     * @param array $params Dynamic route parameters
     */
    private function executeAction(string $action, array $params = []): void
    {
        [$controllerName, $methodName] = explode('@', $action);

        $controllerFile = __DIR__ . '/../controller/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            throw new RuntimeException("Controller file not found: $controllerFile");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new RuntimeException("Controller class not found: $controllerName");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            throw new RuntimeException("Method not found: $controllerName@$methodName");
        }

        $controller->$methodName(...array_values($params));
    }

    /**
     * Handle 404 Not Found
     */
    private function handleNotFound(): void
    {
        http_response_code(404);

        $notFoundView = __DIR__ . '/../view/404.php';
        if (file_exists($notFoundView)) {
            ob_start();
            require $notFoundView;

            $content = ob_get_clean();

            require __DIR__ . '/../view/layout.php';
        } else {
            echo '<h1>404 - Page Not Found</h1>';
        }
    }
}
