<?php

namespace App\Http\Controllers\ref;
use App\Http\Controllers\Controller;
use App\Repositories\Ref\WilayahRepository;
use App\Http\Requests\ref\WilayahStore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use RequestFilterHelper;

class WilayahController extends Controller
{
  use ResponseTrait;

  public function prov(Request $request, WilayahRepository $wilRepository)
  {
    try {
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['kode', 'ASC'],
        'limit'  => 100, //$request->input('length'),
        'start'  => $request->input('start'),
        'search' => $request->input('search'),
      ];
      $prov = $wilRepository->provFiltered($whereKeys);

      return response()->json([
        'message' => '',
        'code' => 200,
        'data' => $prov,
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

  public function kabupaten(Request $request, WilayahRepository $wilRepository)
  {
    try {
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['kode', 'ASC'],
        'limit'  => 100, //$request->input('length'),
        'start'  => $request->input('start'),
        'search' => $request->input('search'),
        'prov'   => $request->input('prov')
      ];
      $kab = $wilRepository->kabFiltered($whereKeys);

      return response()->json([
        'message' => '',
        'code' => 200,
        'data' => $kab,
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

  public function kecamatan(Request $request, WilayahRepository $wilRepository)
  {
    try {
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['kode', 'ASC'],
        'limit'  => 100, //$request->input('length'),
        'start'  => $request->input('start'),
        'search' => $request->input('search'),
        'kab'    => $request->input('kab')
      ];
      $kec = $wilRepository->kecFiltered($whereKeys);

      return response()->json([
        'message' => '',
        'code' => 200,
        'data' => $kec,
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

  public function dataTableJson(Request $request, WilayahRepository $wilRepository)
  {
    try {
      $colOrder = [
        1 => 'kode',
        2 => 'kode',
      ];
      $filterField = [
        'kode' => 'kode'
      ];
      $orderField = isset($colOrder[$request->input('order.0.column')])
        ? $colOrder[$request->input('order.0.column')]
        : null;
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['kode', 'ASC'],
        'limit'  => $request->input('length'),
        'start'  => $request->input('start'),
        'search' => $request->input('search.value'),
        'data'   => RequestFilterHelper::fieldKey($filterField, $request->all()),
      ];

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $wilRepository->totAll($whereKeys),
        'recordsFiltered' => $wilRepository->countFiltered($whereKeys),
        'code' => 200,
        'data' => $wilRepository->limitFiltered($whereKeys),
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