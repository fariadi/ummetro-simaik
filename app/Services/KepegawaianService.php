<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class KepegawaianService {
    private $apiUrl;
    private $apiAuth;

    function __construct($data = []) {
        $this->apiUrl  = env('API_SIMPEG_V2_URL', '');
        $this->apiAuth = env('API_SIMPEG_V2_SECRET', '');
    }

    public function get($route, $data = [])
    {
        $response   = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->apiAuth
        ])->get($this->apiUrl. $route, $data);
        return $response;
    }

    public function post($route, $data = [])
    {
        $response   = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->apiAuth
        ])->post($this->apiUrl. $route, $data);
        return $response;
    }
}
