<?php

declare(strict_types=1);

namespace App\forms;


class LoginForm extends BaseForm
{
    public string $username;
    public string $password;

    protected function getValidationRules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}