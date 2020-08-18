<?php

declare(strict_types=1);

namespace App\services;


use App\forms\LoginForm;

class UserService
{
    private array $inMemoryUsers = [
        'admin' => [
            'username' => 'admin',
            'password' => '123',
            'role' => 'admin'
        ]
    ];

    public function authenticate(LoginForm $form): array
    {
        if (!isset($this->inMemoryUsers[$form->username])) {
            throw new \InvalidArgumentException("Пользователь с таким именем не существует!");
        }

        $user = $this->inMemoryUsers[$form->username];
        if ($form->password != $user['password']) {
            throw new \InvalidArgumentException("Неверный пароль!");
        }

        return $user;
    }

    public static function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return self::isAuthenticated() && $_SESSION['user']['role'] == 'admin';
    }
}