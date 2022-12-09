<?php

namespace BloomNetwork\Models;

class Credentials
{
    private string $username;

    private string $password;

    private string $shop_code;

    public function __construct(string $username, string $password, string $shop_code)
    {
        $this->username  = $username;
        $this->password  = $password;
        $this->shop_code = $shop_code;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
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