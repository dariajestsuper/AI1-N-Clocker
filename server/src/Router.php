<?php

namespace App;

use App\Configuration\RoutesSystem;
use App\Exception\AuthException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use App\Service\JwtService;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use UnexpectedValueException;
use DomainException;

class Router
{
    private const ROUTE_GUARD_CONFIG = [
        '/api' => 'ROLE_USER',
        '/admin' => 'ROLE_ADMIN',
    ];
    public function __invoke(RouteCollection $routes)
    {
        $context = new RequestContext();
        $request = Request::createFromGlobals();
        $context->fromRequest(Request::createFromGlobals());

        // Routing can match routes with incoming requests
        $matcher = new UrlMatcher($routes, $context);
        try {
            $matcher = $matcher->match($_SERVER['REQUEST_URI']??'');

            array_walk($matcher, function(&$param)
            {
                if(is_numeric($param))
                {
                    $param = (int) $param;
                }
            });

            $className = $matcher['controller'];
            $classInstance = new $className();

            $params = array_merge(array_slice($matcher, 2, -1), ['request'=>$request]);

            $response = call_user_func_array(array($classInstance, $matcher['method']), $params);


        } catch (AuthException $exception) {
            $response = new Response(
                $this->formatError($exception->getMessage()),
                Response::HTTP_UNAUTHORIZED
            );
        }catch (ValidationException $exception) {
            $response = new Response($this->formatError($exception->getMessage()));
        } catch (NoConfigurationException | ResourceNotFoundException | MethodNotAllowedException $e) {
            $response = new Response($this->formatError(),Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            $response = new Response($this->formatError(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if($response instanceof Response) {
            $response->send();
        }
    }

    private function checkGuard(string $path)
    {
        foreach (self::ROUTE_GUARD_CONFIG as $route=>$roles){
            $regEx = '^'.$route.'(/.*)?$';
            //TODO check if path from request is guarded & if yes validate token
        }
    }
    private function validateToken(Request $request)
    {
        try {
            $headerToken = $request->headers->get('Authorization');
            JwtService::decode($headerToken);
        } catch (InvalidArgumentException |
        DomainException |
        UnexpectedValueException |
        SignatureInvalidException |
        BeforeValidException |
        BeforeValidException |
        ExpiredException $e) {
         throw new AuthException('Token error');
        }
    }
    private function formatError(?string $message= null): string
    {
        if(!$message) {
            return json_encode(['status'=> 'error']);
        } else {
            return json_encode(['status'=> 'error', 'error_message'=>$message]);
        }
    }
}

// Invoke
$router = new Router();
$routeSystem = new RoutesSystem();
$router($routeSystem->getRouteCollection());