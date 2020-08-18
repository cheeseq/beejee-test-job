<?php

declare(strict_types=1);

namespace App\forms;


use Rakit\Validation\Validator;

abstract class BaseForm
{
    public function collect($postData)
    {
        $classname = (new \ReflectionClass($this))->getShortName();
        if (!isset($postData[$classname])) {
            return;
        }
        foreach ($postData[$classname] as $key => $val) {
            $this->$key = $val;
        }
    }

    public function validate()
    {
        $validator = new Validator;
        $validation = $validator->make((array)$this, $this->getValidationRules());
        $validation->validate();

        return $validation;
    }

    abstract protected function getValidationRules();
}