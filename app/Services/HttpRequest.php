<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class HttpRequest {
    private $secret;

    function __construct() {
        $this->secret  = env('JWT_SECRET', 'ZCrmn4EtbaMjrbTMnyjmBNJKSLQlhZ5iCVYjeuq7eHdkOchC2yI9hQFb7A6wR6XV');
    }

    public function cookieRegister($data)
    {
        $isIAt   = time();
        $isExp   = $isIAt + 60 * 60;  // jwt valid for 1 hours
        $confJwt = [
            'iss' => 'simaik',
            'aud' => 'admin',
            'iat' => $isIAt,
            //'nbf' => $isIAt + 60 * 60,
            'exp' => $isExp,
        ];
        $payload = array_merge($confJwt, $data);
        $jwt = JWT::encode($payload,  $this->secret, 'HS256');

        return $jwt;
    }

    public function cookieRegisterDecode($data)
    {
        try {
            $data = JWT::decode($data, new Key($this->secret, 'HS256'));
            if(isset($data->nbf) > time() ) {
                throw new Exception("Authorization Expired.");
            }
            return $data;
        } catch (\Exception $e) {
            return [];
        }
    }
}