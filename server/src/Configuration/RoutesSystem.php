<?php

namespace App\Configuration;

use App\Controller\DocumentationController;
use App\Controller\LoginController;
use App\Controller\StatisticsController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RoutesSystem
{
    private RouteCollection $routeCollection;
    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
        $this->routeCollection->add(
            'login',
            new Route(
                constant('URL_SUBFOLDER').'/authorization_token',
                array('controller' => LoginController::class, 'method' => 'login'),
                array()
            )
        );
        $this->routeCollection->add(
            'register',
            new Route(
                constant('URL_SUBFOLDER').'/register',
                array('controller' => LoginController::class, 'method' => 'register'),
                array()
            )
        );
        $this->routeCollection->add(
            'docs',
            new Route(
                constant('URL_SUBFOLDER').'/docs',
                array('controller' => DocumentationController::class, 'method' => 'index'),
                array()
            )
        );
        $this->routeCollection->add(
            'statistics',
            new Route(
                constant('URL_SUBFOLDER').'/stats',
                array('controller' => StatisticsController::class, 'method' => 'index'),
                array()
            )
        );

    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection(): RouteCollection
    {
        return $this->routeCollection;
    }

}