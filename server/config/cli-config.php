<?php

use App\Configuration\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

include_once "config.php";
$entityManager = EntityManager::getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
