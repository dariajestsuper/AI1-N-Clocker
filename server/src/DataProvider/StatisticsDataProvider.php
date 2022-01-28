<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Model\Statistics;
use App\Repository\UserRepository;

final class StatisticsDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): Statistics
    {
        $userCount = $this->repository->userCount();
        $statistics = new Statistics();
        $statistics->setUserCount($userCount);
        return $statistics;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Statistics::class === $resourceClass;
    }
}