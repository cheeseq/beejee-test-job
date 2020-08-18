<?php

declare(strict_types=1);

namespace App\forms;


class UpdateTaskForm extends BaseForm
{
    public string $id;
    public string $text;

    protected function getValidationRules()
    {
        return [
            'id' => 'required',
            'text' => 'required'
        ];
    }
}