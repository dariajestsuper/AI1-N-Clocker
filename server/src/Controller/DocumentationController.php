<?php


namespace App\Controller;


use OpenApi\Generator;
use OpenApi\Attributes as OA;

#[OA\Info(version: '0.0.1', title: 'Clocker Open API')]
class DocumentationController
{
    public function index()
    {
        $openapi = Generator::scan([APP_ROOT.'/src/Controller']);

        header('Content-Type: application/json');
        echo $openapi->toJson();
    }
}