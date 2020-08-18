<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\controllers;


use App\forms\LoginForm;
use App\services\UserService;

class AuthController extends BaseController
{
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function showLoginForm()
    {
        if (UserService::isAuthenticated()) {
            $this->redirect("/tasks");
        }

        $this->view->render("login");
    }

    public function handleLoginForm()
    {
        if (UserService::isAuthenticated()) {
            $this->redirect("/tasks");
        }

        $form = new LoginForm();
        $form->collect($_POST);

        $validation = $form->validate();

        if ($validation->passes()) {
            try {
                $user = $this->userService->authenticate($form);
                unset($user["password"]);
                $_SESSION["user"] = $user;

                $this->redirect("/tasks");
            } catch (\InvalidArgumentException $e) {
                $validation->errors->add("invalidCredentials", "invalidCredentials", $e->getMessage());
            }
        }

        $this->view->setVar("validationErrors", $validation->errors());

        $this->view->render("login");
    }

    public function logout()
    {
        if (!UserService::isAuthenticated()) {
            $this->redirect("/tasks");
        }

        unset($_SESSION["user"]);
        $this->redirect("/tasks");
    }
}