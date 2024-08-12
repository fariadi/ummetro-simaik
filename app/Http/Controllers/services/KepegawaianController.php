<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Services\KepegawaianService;
use Carbon\Carbon;
use ComponentHelper;

class KepegawaianController extends Controller
{
    use ResponseTrait;

    public function apiGet(Request $request, $path)
    {
        $kepegawaianservice = new KepegawaianService();
        try {
            $response = $kepegawaianservice->get($path, $request->all());
            return response()->json(json_decode($response->body()), $response->status());
        }
        catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function apiPost(Request $request, $path)
    {
        $kepegawaianservice = new KepegawaianService();
        try {
            $response = $kepegawaianservice->post($path, $request->all());
            return response()->json(json_decode($response->body()), $response->status());
        }
        catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}