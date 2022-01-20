<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class BaseTemplateController
{
    private string $template;

    public function __construct(string $templateName)
    {
        $this->template = $this->getTemplate(APP_ROOT."/views/".$templateName.".php");
    }

    private function getTemplate(string $path): string
    {
        $file = file_get_contents($path);
        if (!!$file) {
            return $file;
        }else {
            throw new FileNotFoundException($path);
        }
    }
}