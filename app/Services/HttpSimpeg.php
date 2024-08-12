<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class HttpSimpeg {
    private $secret;
    private $apiUrl;
    public  $apiAuth;

    function __construct() {
      $this->secret   = env('API_SIMPEG_SECRET','Univ%Muh%Metr0+');
      $this->apiUrl   = env('API_SIMPEG_URL', 'https://simpeg.ummetro.ac.id/');
    }

    public function request($method, $route, $data = []) 
    {
      try {
          
        if($method == 'GET') {
          $response   = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $this->token()
          ])->get($this->apiUrl. $route, $data);
        }
        
        if($method == 'POST') {
          $response   = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $this->token()
          ])->post($this->apiUrl. $route, $data);
        }

        if($method == 'PUT') {
          $response   = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->token()
          ])->put($this->apiUrl. $route, $data);
        }

        if($method == 'DELETE') {
          $response   = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->token()
          ])->delete($this->apiUrl. $route);
        }

        if($response->status() === 401) {
          return (object) array('code' => $response->status(), 'messages'=> 'Token tidak valid');
        }

        if($response->status() !== 200) {
          $body     = json_decode($response->body());
          $isMsg    = (isset($body->message)) ? $body->message : '';
          $messages = ( $response->status() == 202 ) ? $isMsg : 'Error service '.$this->apiUrl . '  '. $isMsg;

          return (object) array('code' => $response->status(), 'messages'=> $messages, 'data' => []);
        }

        $dataBody = new \stdClass();
        $dataBody = json_decode($response->body());
        
        if(!isset($dataBody->code)) {
          $dataBody->code = 200;
        }  
        
        return $dataBody;
      }
      catch (\Exception $e) {
        return (object) array('code' => 500, 'messages'=> $e->getMessage(), 'data'=> []);
      }
    }

    public function token()
    {
        $isIAt   = time();
        $isExp   = $isIAt + 60 * 60;  // jwt valid for 1 hours
        $data    = [];
        $confJwt = [
            //'iss' => 'simaik',
            //'aud' => 'admin',
            //'iat' => $isIAt,
            //'nbf' => $isIAt + 60 * 60,
            //'exp' => $isExp,
        ];
        $payload = array_merge($confJwt, $data);
        $jwt = JWT::encode($payload,  $this->secret, 'HS256');

        return $jwt;
    }

       

}
