<?php

declare(strict_types=1);

namespace App\forms;


class AddTaskForm extends BaseForm
{
    public string $username;
    public string $email;
    public string $text;

    protected function getValidationRules()
    {
        return [
            'username' => 'required',
            'email' => 'required|email',
            'text' => 'required',
        ];
    }
}