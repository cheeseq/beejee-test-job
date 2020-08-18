<?php

declare(strict_types=1);
namespace App;


class View
{
    private string $content;
    private array $vars = [];

    public function render($viewName)
    {
        $templatePath = __DIR__ . "/views/$viewName.php";

        if (!is_file($templatePath)) {
            throw new \InvalidArgumentException("Invalid view name passed - $viewName");
        }

        ob_start();
        require_once $templatePath;
        $this->setContent(ob_get_contents());
        ob_end_clean();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getVar($name)
    {
        return $this->vars[$name];
    }

    public function hasVar($name): bool
    {
        return isset($this->vars[$name]);
    }

    public function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }


}