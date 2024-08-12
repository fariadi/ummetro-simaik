<?php

namespace App\Http\Controllers\bbq;
use App\Http\Controllers\Controller;
use App\Repositories\Bbq\MentorRepository;
use App\Http\Requests\bbq\MentorStore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use RequestFilterHelper;

class MentorController extends Controller
{
  use ResponseTrait;

  public function store(MentorStore $request, MentorRepository $mentorRepository)
  {
    try {
      $data = $mentorRepository->create($request->all());
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $exception) {
      return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

}