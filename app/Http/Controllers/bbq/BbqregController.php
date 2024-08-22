<?php

namespace App\Http\Controllers\bbq;
use App\Http\Controllers\Controller;
use App\Repositories\Bbq\BbqregRepository;
use App\Http\Requests\bbq\BbqregStore;
use App\Http\Requests\bbq\PertemuanStore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use RequestFilterHelper;

class BbqregController extends Controller
{
  use ResponseTrait;

  public function store(BbqregStore $request, BbqregRepository $bbqregRepository)
  {
    try {
      $data = $bbqregRepository->create($request->all());
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $exception) {
      return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(BbqregRepository $bbqregRepository, $id): JsonResponse
  {
    try {
      $data = $bbqregRepository->getByID($id);
      if (is_null($data)) {
        return $this->responseError(null, 'Data Not Found', Response::HTTP_NOT_FOUND);
      }
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function dataTableJson(Request $request, BbqregRepository $bbqregRepository)
  {
    try {
      $colOrder = [
        1 => 'id',
        2 => 'id',
      ];
      $filterField = [
        'pegawai_id' => 'pegawai_id',
        'mentor_user_id' => 'mentor_user_id',
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
      $isValidasi =  ($request->input('validasi')) 
        ? $request->input('validasi') 
        : '';
      $isFiltered = RequestFilterHelper::fieldKey($filterField, $request->all());
      if($isValidasi == 'show') {
        $isFiltered[] = ['mentor_validasi', '<>', null];
      }
      else {
        $isFiltered[] = ['mentor_validasi', '=', null];
      }
      
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['id', 'ASC'],
        'limit'  => $request->input('length'),
        'start'  => $request->input('start'),
        'search' => $search,
        'data'   => $isFiltered,
      ];

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $bbqregRepository->totAll($whereKeys),
        'recordsFiltered' => $bbqregRepository->countFiltered($whereKeys),
        'code' => 200,
        'data' => $bbqregRepository->limitFiltered($whereKeys)
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

  public function destroy(BbqregRepository $bbqregRepository, $id): JsonResponse
  {
    try {
      $data = $bbqregRepository->getByID($id);
      if (empty($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      $deleted = $bbqregRepository->delete($id);
      if (!$deleted) {
        return $this->responseError(null, 'Failed to delete.', Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function pertemuanUpdate(PertemuanStore $request, BbqregRepository $bbqregRepository, $id)
  {
    try {
      $data = $bbqregRepository->update($id, $request->all());
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function mentorValidasi(Request $request, BbqregRepository $bbqregRepository, $id)
  {
    try {
      $value = $request->only(['mentor_validasi']);
      $data = $bbqregRepository->update($id, $value);
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  

}