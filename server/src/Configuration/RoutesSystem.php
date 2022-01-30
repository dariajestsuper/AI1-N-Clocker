<?php

namespace App\Configuration;

use App\Controller\DocumentationController;
use App\Controller\LoginController;
use App\Controller\ProjectController;
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
                path:constant('URL_SUBFOLDER').'/authorization_token',
                defaults: ['controller' => LoginController::class, 'method' => 'login'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'register',
            new Route(
                path: constant('URL_SUBFOLDER').'/register',
                defaults: ['controller' => LoginController::class, 'method' => 'register'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'docs',
            new Route(
                path:constant('URL_SUBFOLDER').'/docs',
                defaults:['controller' => DocumentationController::class, 'method' => 'index'],
                methods: ['GET']
            )
        );
        $this->routeCollection->add(
            'statistics',
            new Route(
                path:constant('URL_SUBFOLDER').'/stats',
                defaults: ['controller' => StatisticsController::class, 'method' => 'index'],
                methods: ['GET']
            )
        );
        $this->routeCollection->add(
            'get_project',
            new Route(
                path: constant('URL_SUBFOLDER').'/api/projects/{id}',
                defaults: ['controller' => ProjectController::class, 'method' => 'getProject'],
                requirements: ['id' => '[0-9]+'],
                methods: ['GET']
            )
        );
        $this->routeCollection->add(
            'post_project',
            new Route(
                path: constant('URL_SUBFOLDER').'/api/projects',
                defaults: ['controller' => ProjectController::class, 'method' => 'postProject'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'post_project_task',
            new Route(
                path: constant('URL_SUBFOLDER').'/api/projects/{id}/task',
                defaults: ['controller' => ProjectController::class, 'method' => 'postProjectTask'],
                requirements: ['id' => '[0-9]+'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'post_task_log_time',
            new Route(
                path:constant('URL_SUBFOLDER').'/api/projects/{projectId}/task/{taskId}',
                defaults: ['controller' => ProjectController::class, 'method' => 'postLogTime'],
                requirements:['projectId' => '[0-9]+', 'taskId' => '[0-9]+'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'get_task_log_time',
            new Route(
                path:constant('URL_SUBFOLDER').'/api/projects/{projectId}/task/{taskId}/logs',
                defaults: ['controller' => ProjectController::class, 'method' => 'getTaskLogs'],
                requirements:['projectId' => '[0-9]+', 'taskId' => '[0-9]+'],
                methods: ['GET']
            )
        );
        $this->routeCollection->add(
            'post_end_log_time',
            new Route(
                path:constant('URL_SUBFOLDER').'/api/projects/{projectId}/task/{taskId}/logs/{logId}',
                defaults: ['controller' => ProjectController::class, 'method' => 'postEndTimeLog'],
                requirements:['projectId' => '[0-9]+', 'taskId' => '[0-9]+','logId' => '[0-9]+'],
                methods: ['POST']
            )
        );
        $this->routeCollection->add(
            'delete_task',
            new Route(
                path:constant('URL_SUBFOLDER').'/api/projects/{projectId}/task/{taskId}',
                defaults: ['controller' => ProjectController::class, 'method' => 'deleteTask'],
                requirements:['projectId' => '[0-9]+', 'taskId' => '[0-9]+'],
                methods: ['DELETE']
            )
        );
        $this->routeCollection->add(
            'delete_project',
            new Route(
                path:constant('URL_SUBFOLDER').'/api/projects/{projectId}',
                defaults: ['controller' => ProjectController::class, 'method' => 'deleteProject'],
                requirements:['projectId' => '[0-9]+'],
                methods: ['DELETE']
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