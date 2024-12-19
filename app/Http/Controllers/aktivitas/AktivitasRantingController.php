<?php

namespace App\Http\Controllers\aktivitas;

use App\Http\Controllers\Controller;
use App\Repositories\Aktivitas\AktivitasRantingRepository;
use App\Http\Requests\aktifitas\RantingStore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\PaginateCollection;

use App\Models\Aktivitas\AktivitasRantingModel;

use App\Helpers\RequestFilterHelper;

class AktivitasRantingController extends Controller
{
  use ResponseTrait;

  public function index(
    PaginateRequest $request,
  ) {
    try {
      $filterField   = [
        'id' => 'id',
        'pegawai_id' => 'pegawai_id'
      ];
      $search     = $request->input('search') ? $request->input('search') : '';
      $whereValue = RequestFilterHelper::fieldKey($filterField, $request->all());

      $paginate = AktivitasRantingModel::with(['pegawai' => function ($query) use ($search) {
        $query->where('nama_lengkap', 'LIKE', "%{$search}%");
      }])
        ->where($whereValue)
        ->orderBy('id', 'asc')
        ->paginate($request->input('limit'));

      $data = new PaginateCollection($paginate);
      return response()->json($data, 200);
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

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
