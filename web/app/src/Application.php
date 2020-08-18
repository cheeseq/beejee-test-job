<?php

declare(strict_types=1);
namespace App;


use App\config\Database;
use App\config\Router;

class Application
{
    private static Application $instance;
    private View $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public static function getInstance(): Application
    {
        if (!isset(self::$instance)) {
            self::$instance = new Application(new View());
        }
        return self::$instance;
    }


    public function run()
    {
        session_start();

        $database = new Database();
        $router = new Router();

        $database->initialize();
        $router->initialize();
    }

    public function getView(): View
    {
        return $this->view;
    }

    public function setView(View $view)
    {
        $this->view = $view;
    }
}