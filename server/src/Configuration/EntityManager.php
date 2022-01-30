<?php

namespace App\Configuration;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as EM;

class EntityManager
{
    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public static function getEntityManager(): EM
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $config = Setup::createAttributeMetadataConfiguration(
            array(APP_ROOT."/src"),
            $isDevMode,
            $proxyDir,
            $cache
        );

        $conn = array(
            'dbname' => 'clocker',
            'user' => 'root',
            'password' => 'my_secret_pw_shh',
            'host' => 'clocker_db',
            'driver' => 'pdo_mysql',
        );
        $em = EM::create($conn, $config);
        $em->clear();
        return $em;
    }
}