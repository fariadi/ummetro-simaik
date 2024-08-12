<?php

namespace App\Repositories\Pegawai;

use Illuminate\Support\Str;
use App\Interfaces\HttpInterface;
use App\Services\HttpSimpeg;



class PegawaiRepository implements HttpInterface
{
  public function getByField($data)
  {
    $response = new \stdClass();
    $keys = isset($data['data'])    ? $data['data'] : ['id' => null];
    try {
        $client = new HttpSimpeg();
        $pegawai = $client->request('POST', 'api/pegawai/detail', ['keys' => $keys]);
  
        return $pegawai;
    } catch (\Exception $e) {
        $response->code = 500;
        $response->message = $e->getMessage();
        return $e->getMessage();
    }
  }
}