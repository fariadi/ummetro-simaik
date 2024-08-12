<?php

namespace App\Http\Controllers\aktivitas;
use App\Http\Controllers\Controller;
use App\Repositories\Aktivitas\AktivitasRantingRepository;
use App\Http\Requests\aktifitas\RantingStore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use RequestFilterHelper;

class AktivitasRantingController extends Controller
{
  use ResponseTrait;

  public function store(RantingStore $request, AktivitasRantingRepository $aktivitasRepository)
  {
    try {
      $data = $aktivitasRepository->create($request->all());
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $exception) {
      return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

}