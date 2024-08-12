<?php

namespace App\Http\Controllers\ref;
use App\Http\Controllers\Controller;
use App\Repositories\Ref\AlquranRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use RequestFilterHelper;

class AlquranController extends Controller
{
  use ResponseTrait;

  public function store(Request $request, AlquranRepository $alquranRepository)
  {
    try {
      $data = $alquranRepository->create($request->all());
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $exception) {
      return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function update(Request $request, AlquranRepository $alquranRepository, $id): JsonResponse
  {
    try {
      $data = $alquranRepository->update($id, $request->all());
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(AlquranRepository $alquranRepository, $id): JsonResponse
  {
    try {
      $data = $alquranRepository->getByID($id);
      if (is_null($data)) {
        return $this->responseError(null, 'Data Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function destroy(AlquranRepository $alquranRepository, $id): JsonResponse
  {
    try {
      $data = $alquranRepository->getByID($id);
      if (empty($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      $deleted = $alquranRepository->delete($id);
      if (!$deleted) {
        return $this->responseError(null, 'Failed to delete.', Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function dataTableJson(Request $request, AlquranRepository $alquranRepository)
  {
    try {
      $colOrder = [
        1 => 'surat_ke',
        2 => 'nama_surat',
      ];
      $filterField = [
        'surat_ke' => 'surat_ke'
      ];
      $search  = ($request->input('search')) 
        ? $request->input('search') 
        : '';
      $search  = (is_array($search)) 
        ? $search['value'] 
        : $search;
      $orderField = isset($colOrder[$request->input('order.0.column')])
        ? $colOrder[$request->input('order.0.column')]
        : null;
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['surat_ke', 'ASC'],
        'limit'  => $request->input('length'),
        'start'  => $request->input('start'),
        'search' => $search,
        'data'   => RequestFilterHelper::fieldKey($filterField, $request->all()),
      ];

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $alquranRepository->totAll($whereKeys),
        'recordsFiltered' => $alquranRepository->countFiltered($whereKeys),
        'code' => 200,
        'data' => $alquranRepository->limitFiltered($whereKeys),
      ]);
    } catch (\Exception $e) {
      return response()->json(
        [
          'message' => $e->getMessage(),
          'code' => 500,
          'data' => [],
        ],
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

}