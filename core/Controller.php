<?php

class Controller
{
    /**
     * Render a view with the layout
     * 
     * @param string $view View name (without .php extension)
     * @param array $data Data to pass to the view
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        ob_start();
        
        $viewFile = __DIR__ . '/../view/' . $view . '.php';
        
        require $viewFile;
        
        $content = ob_get_clean();

        require __DIR__ . '/../view/layout.php';
    }

    /**
     * Redirect to another URL
     * 
     * @param string $url URL to redirect to
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
