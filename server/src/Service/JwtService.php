<?php

namespace App\Service;

use App\Model\JwtPayload;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use UnexpectedValueException;
use DomainException;

class JwtService
{
    private const KEY = "SECRET";

    public static function encode(JwtPayload $jwtPayload): string
    {
        return JWT::encode($jwtPayload->__toArray(), self::KEY, 'HS256');
    }

    /**
     * @throws InvalidArgumentException     Provided key/key-array was empty
     * @throws DomainException              Provided JWT is malformed
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     */
    public static function decode(string $jwt): JwtPayload
    {
        $jwtOb = JWT::decode($jwt, new Key(self::KEY, 'HS256'));

        return new JwtPayload(
            $jwtOb->sub,
            $jwtOb->username,
            $jwtOb->roles
        );
    }
}