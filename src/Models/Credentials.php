<?php

namespace BloomNetwork\Models;

class Credentials
{
    private string $username;

    private string $password;

    private string $shop_code;

    public function __construct(string $username, string $password, string $shop_code)
    {
        $this->username = $username;
        $this->password = $password;
        $this->shop_code = $shop_code;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getShopCode(): string
    {
        return $this->shop_code;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'shopCode' => $this->shop_code,
        ];
    }
}
