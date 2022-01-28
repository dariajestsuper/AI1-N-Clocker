<?php

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\StatisticsController;

#[ApiResource(
    itemOperations: [
    'get_statistics' => [
        'method' => 'GET',
        'path' => '/statistics',
        'controller' => StatisticsController::class,
    ],
])]
class Statistics
{

    #[ApiProperty(identifier: true)]
    private int $userCount;

    public function getUserCount(): int
    {
        return $this->userCount;
    }

    public function setUserCount(int $userCount): void
    {
        $this->userCount = $userCount;
    }
}