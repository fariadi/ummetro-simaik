<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use App\Services\HttpSimpeg;

use App\Traits\ResponseTrait;
use File;
use RequestFilterHelper;

class PegawaiController extends Controller
{
  use ResponseTrait;


  public function index(): JsonResponse
  {
    $length = $request->input('length') ? $request->input('length') : 10;
    try {
      $client = new HttpSimpeg();
      $pegawai = $client->request('GET', 'api/pegawai/list', ['limit' => $length]);

      return $this->responseSuccess($pegawai, 'Profile Fetched Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(
    PegawaiRepository $pegawaiRepository,
    $id=null
  ): JsonResponse
  {
    //$client = new HttpSimpeg();
    $data = $pegawaiRepository->getByField(['data' => ['id' => $id]]);
    //$data = $client->token();
    return response()->json($data);
  }

  public function dataTableJson(Request $request)
  {
      $length = $request->input('length') ? $request->input('length') : 10;
      $start = $request->input('start') ? $request->input('start') : 0;
      $search = ($request->input('search')) ? $request->input('search') : '';
      $search = (is_array($search)) ? $search['value'] : $search;
      try {
        $client = new HttpSimpeg();
        $pegawai = $client->request('GET', 'api/pegawai/list', ['limit' => $length, 'offsite' => $start, 'search' => $search]);
      } catch (\Exception $e) {
        return response()->json(
          [
            'messages' => $e->getMessage(),
            'code' => 500,
            'data' => [],
          ],
          Response::HTTP_INTERNAL_SERVER_ERROR
        );
      }
       return  response()->json($pegawai);
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => isset($pegawai->total) ? $pegawai->total : 0,
        'recordsFiltered' => isset($pegawai->totalFilter) ? $pegawai->totalFilter : 0,
        'code' => 200,
        'messages' => 'Ok!.',
        'data' => $pegawai->data,
      ]);
  }

}