<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatisticsController
{
    public function index(
        Request $request
    ): Response {


        return new Response(null,200);
    }
}