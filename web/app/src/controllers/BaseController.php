<?php

declare(strict_types=1);

namespace App\controllers;


use App\Application;
use App\View;

abstract class BaseController
{
    protected Application $app;
    protected View $view;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->view = $this->app->getView();
    }

    protected function redirect($location)
    {
        header("Location: $location");
        exit();
    }

    protected function goBack()
    {
        $referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : "/";
        $this->redirect($referer);
    }

    protected function jsonOutput($output)
    {
        echo json_encode($output);
        exit();
    }
}