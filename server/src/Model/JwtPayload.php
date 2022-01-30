<?php

namespace App\Model;

use JetBrains\PhpStorm\ArrayShape;

class JwtPayload
{
    private string $sub;
    private string $username;
    private array $roles;

    public function __construct(
        string $sub,
        string $username,
        array $roles
    ) {
        $this->sub = $sub;
        $this->username = $username;
        $this->roles = $roles;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSub(): string
    {
        return $this->sub;
    }

    public function setSub(string $sub): void
    {
        $this->sub = $sub;
    }

    #[ArrayShape(['sub' => "string", 'username' => "string", 'roles' => "array"])]
    public function __toArray(): array
    {
        return ['sub'=>$this->sub,'username'=>$this->username,'roles'=>$this->roles];
    }
}