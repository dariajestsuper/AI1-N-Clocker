<?php


namespace App\Model;


class Statistics
{
    private int $userCount;

    public function __construct(int $userCount)
    {
        $this->userCount = $userCount;
    }

}