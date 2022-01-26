<?php

namespace scandiweb\Factory;

class Router
{
    /**
     * @var array $path
     */
    private array $path;


    /**
     * @param string $path
     * @param string $page
     * @return void
     */
    public function get(string $path, string $page): void
    {
        $this->path[] = array($path, $page, 'get');
    }


    /**
     * @param string $path
     * @param string $page
     * @return void
     */

    public function post(string $path, string $page): void
    {
        $this->path[] = array($path, $page, 'post');
    }


    /**
     * @return void
     */
    public function run()
    {
        $route = array_search($_SERVER['REQUEST_URI'], array_column($this->path, 0));
        if ($route !== false)
        {
            require $this->path[$route][1];
        }
        else{
            require 'endpoints/404.php';
        }
    }
}