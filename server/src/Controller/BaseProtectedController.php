<?php


namespace App\Controller;


use App\Exception\AuthException;
use App\Service\JwtService;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use UnexpectedValueException;
use DomainException;

class BaseProtectedController
{
    protected function validateToken(Request $request)
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
        var_dump('ok');
    }
}