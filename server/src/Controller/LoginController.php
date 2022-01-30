<?php

namespace App\Controller;

use App\Exception\AuthException;
use App\Exception\ValidationException;
use App\Model\JwtPayload;
use App\Repository\UserRepository;
use App\Service\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class LoginController
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = UserRepository::create();
    }

    /**
     * @throws AuthException
     * @throws ValidationException
     */
    #[OA\Post(path: '/authorization_token', operationId: 'authorization_token')]
    #[OA\Response(response: '200', description: 'An example resource')]
    public function login(
        Request $request
    ): Response {
        $body = json_decode($request->getContent(), true);
        $this->validatePostData($body);
        $user = $this->repository->login($body['username'], $body['password']);
        $time = new \DateTime();
        $jwtPayload = new JwtPayload($time->getTimestamp(),$user->getUsername(),$user->getRoles());
        $token = JwtService::encode($jwtPayload);

        return new Response(json_encode(['token'=> $token]), Response::HTTP_OK);
    }

    /**
     * @throws ValidationException
     * @throws AuthException
     */
    public function register(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        $this->validatePostData($body);
        $this->repository->register($body['username'],$body['password']);
        return new Response(json_encode(['status' => 'ok']), Response::HTTP_OK);
    }

    /**
     * @throws ValidationException
     */
    private function validatePostData(?array $body)
    {
        if (!isset($body['username']) || !isset($body['password'])) {
            throw new ValidationException('Missing keys in POST body');
        }
    }

}
