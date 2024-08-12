<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Pegawai\PegawaiRepository;
use App\Repositories\Pegawai\BiodataRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use App\Services\HttpSimpeg;

use App\Traits\ResponseTrait;
use File;
use RequestFilterHelper;

class BiodataController extends Controller
{
  use ResponseTrait;

  public function rantingUpdate(
    Request $request, 
    BiodataRepository $biodataRepository, $id): JsonResponse
  {
    try {
      $data = $biodataRepository->update($id, $request->all());
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}