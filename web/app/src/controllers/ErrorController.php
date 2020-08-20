<?php /** @noinspection PhpUnused */

declare(strict_types=1);
namespace App\controllers;


class ErrorController extends BaseController
{
    public function notFound()
    {
        $this->view->setContent('<p>Страница не найдена :(</p>');
    }
}