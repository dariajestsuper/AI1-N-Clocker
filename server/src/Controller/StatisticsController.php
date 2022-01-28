<?php

namespace App\Controller;

use App\Model\Statistics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class StatisticsController extends AbstractController
{

    #[Route(
        path: '/statistics',
        name: 'get_statistics',
        defaults: [
        '_api_resource_class' => Statistics::class,
        '_api_item_operation_name' => 'get_statistics',
    ],
        methods: ['GET'],
    )]
    public function __invoke(Statistics $data): Statistics
    {
        return $data;
    }
}