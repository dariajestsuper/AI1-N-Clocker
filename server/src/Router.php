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
        '/api' => ['ROLE_USER'],
        '/admin' => ['ROLE_ADMIN'],
    ];

    public function __invoke(RouteCollection $routes)
    {
        $context = new RequestContext();
        $request = Request::createFromGlobals();
        $context->fromRequest(Request::createFromGlobals());

        if ($request->getMethod() === 'OPTIONS') {
            $response = new Response(json_encode(['status'=>'ok']), Response::HTTP_OK);
            $response->headers->add(['Access-Control-Allow-Origin: *']);
            $response->send();
        } else {

            // Routing can match routes with incoming requests
            $matcher = new UrlMatcher($routes, $context);
            try {
                $matcher = $matcher->match($_SERVER['REQUEST_URI'] ?? '');
                [$isGuarded, $roles] = $this->checkGuard($_SERVER['REQUEST_URI']);
                if ($isGuarded) {
                    $this->validateToken($request, $roles);
                }
                array_walk(
                    $matcher,
                    function (&$param) {
                        if (is_numeric($param)) {
                            $param = (int)$param;
                        }
                    }
                );

                $className = $matcher['controller'];
                $classInstance = new $className();

                $params = array_merge(array_slice($matcher, 2, -1), ['request' => $request]);

                $response = call_user_func_array(array($classInstance, $matcher['method']), $params);


            } catch (AuthException $exception) {
                $response = new Response(
                    $this->formatError($exception->getMessage()),
                    Response::HTTP_UNAUTHORIZED
                );
            } catch (ValidationException $exception) {
                $response = new Response($this->formatError($exception->getMessage()));
            } catch (NoConfigurationException | ResourceNotFoundException | MethodNotAllowedException $e) {
                $response = new Response($this->formatError(), Response::HTTP_NOT_FOUND);
            } catch (\Exception $exception) {
                var_dump($exception);
                $response = new Response($this->formatError(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            if ($response instanceof Response) {
                $response->headers->add(['Access-Control-Allow-Origin: *']);
                $response->send();
            }
        }
    }

    private function checkGuard(
        string $path
    ): array {
        foreach (self::ROUTE_GUARD_CONFIG as $route => $roles) {
            $regEx = sprintf('%s%s%s', '[^', $route, '(/.*)?$]');
            preg_match($regEx, $path, $matches);
            if ($matches) {
                return [true, $roles];
            }
        }

        return [false, ['PUBLIC_ACCESS']];
    }

    private function validateToken(Request $request, array $roles)
    {
        try {
            $headerToken = $request->headers->get('Authorization');
            $payload = JwtService::decode($headerToken);
            $hasAccess = false;
            foreach ($roles as $role) {
                if (in_array($role, $payload->getRoles())) {
                    $hasAccess = true;
                }
            }
            if (!$hasAccess) {
                throw new AuthException('You have no access to this resource!');
            }
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

    private function formatError(?string $message = null): string
    {
        if (!$message) {
            return json_encode(['status' => 'error']);
        } else {
            return json_encode(['status' => 'error', 'error_message' => $message]);
        }
    }
}

// Invoke
$router = new Router();
$routeSystem = new RoutesSystem();
$router($routeSystem->getRouteCollection());