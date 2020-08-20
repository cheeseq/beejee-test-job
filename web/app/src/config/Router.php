<?php

declare(strict_types=1);

namespace App\config;

use Bramus\Router\Router as ExternalRouter;

class Router
{
    public function initialize()
    {
        $router = new ExternalRouter();
        $router->setNamespace("App\controllers");

        $this->addRoutes($router);

        $router->set404("ErrorController@notFound");

        $router->run();
    }

    private function addRoutes(ExternalRouter $router)
    {
        $router->get("/", function () {
            header("Location: /tasks");
            exit();
        });

        $router->get("/tasks(/\d+)?", "TasksController@showTasksPage");
        $router->post("/tasks", "TasksController@addTask");
        $router->get("/tasks/complete/(\d+)", "TasksController@completeTask");
        $router->post("/tasks/update", "TasksController@updateTask");

        $router->get("/login", "AuthController@showLoginForm");
        $router->post("/login", "AuthController@handleLoginForm");

        $router->get("/logout", "AuthController@logout");
    }
}