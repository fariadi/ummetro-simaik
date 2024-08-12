<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Repositories\Users\UsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use App\Traits\ResponseTrait;
use File;
use RequestFilterHelper;

class UsersController extends Controller
{
  use ResponseTrait;

  public function dataTableJson(Request $request, UsersRepository $usersRepository)
  {
    try {
      $colOrder = [
        1 => 'name',
        2 => 'created_at',
      ];
      $filterField = [
        'created_at' => 'created_at',
        'name' => 'name',
        'email' => 'email',
        'created_at' => 'created_at',
      ];
      $orderField = isset($colOrder[$request->input('order.0.column')])
        ? $colOrder[$request->input('order.0.column')]
        : null;
      
      $whereKeys = [
        'order' => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['created_at', 'desc'],
        'limit' => $request->input('length'),
        'start' => $request->input('start'),
        'search' => $request->input('search.value'),
        'data' => RequestFilterHelper::fieldKey($filterField, $request->all()),
        'whith' => []
      ];

      if($request->input('roles_id')) {
        $whereKeys['whith']['roles'] = [['roles_id', '=', $request->input('roles_id')]];
      }

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $usersRepository->totAll($whereKeys),
        'recordsFiltered' => $usersRepository->countFiltered($whereKeys),
        'code' => 200,
        'messages' => 'Ok!.',
        'data' => $usersRepository->limitFiltered($whereKeys),
      ]);
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
  }

  public function upload(
    Request $request,
    UsersRepository $usersRepository
  ) {
      $user = Auth::guard('peserta')->user();
      $this->validate($request, [
          'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
      ]);
      
      try {
          $photo = $user->photo;
          $image_path = $request->file('image')->store('images/user/aik', 'public');
          $userUpdate = $usersRepository->update($user->id, ['foto' => $image_path]);

          if(File::exists(public_path('storage/' . $photo))){
            File::delete(public_path('storage/' . $photo));
          }

          return $this->responseSuccess($userUpdate, 'Ok !');
      } catch (\Exception $e) {
          return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  }

  public function profilPeserta(): JsonResponse
  {
    try {
      $data = Auth::guard('peserta')->user();
      return $this->responseSuccess($data, 'Profile Fetched Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function updateRoles(
    Request $request,
    UsersRepository $usersRepository, 
    $id
  ): JsonResponse {
    try {
      $data = $usersRepository->getByID($id);
      if (is_null($data)) {
        return $this->responseError(null, 'Data Not Found', Response::HTTP_NOT_FOUND);
      }
      /**
       * Delete Roles
       */
      \App\Models\UserRoles::where('users_id',$id)->delete();

      /**
      * Insert roles
      */
      $roles = $request->input('roles_id');
      if (is_array($roles)) {
        foreach ($roles as $key => $value) {
          # code...
          \App\Models\UserRoles::updateOrCreate([
            'users_id' => $id,
            'roles_id' => $value
          ]);
        }
      }
      /*
      $groupCreate = \App\Models\UserRoles::updateOrCreate([
        'users_id' => $id,
        'roles_id' => $request->input('roles_id')
      ]);
      */

      return $this->responseSuccess($roles, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(UsersRepository $usersRepository, $id): JsonResponse
  {
    try {
      $data = $usersRepository->getByID($id);
      if (is_null($data)) {
        return $this->responseError(null, 'Data Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function destroy(
    UsersRepository $usersRepository,
    $id
  ): JsonResponse {
      try {
          $data = $usersRepository->getByID($id);
          if (empty($data)) {
              return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
          }

          /**
           * Delete user
           */
          $deleted = $usersRepository->delete($id);
          if (!$deleted) {
              return $this->responseError(null, 'Failed to delete.', Response::HTTP_INTERNAL_SERVER_ERROR);
          }

          return $this->responseSuccess($data, 'Ok !');
      } catch (\Exception $e) {
          return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  }
}
