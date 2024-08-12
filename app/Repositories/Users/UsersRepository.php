<?php

namespace App\Repositories\Users;

use Illuminate\Support\Str;
use App\Interfaces\UsersInterface;

use Illuminate\Support\Facades\DB;
use App\Models\User as Model;
use Illuminate\Contracts\Pagination\Paginator;

class UsersRepository implements UsersInterface
{
  public function getByID($id): Model|null
  {
    return Model::with('pegawai.mentor')->find($id);
  }

  public function update($id, array $records): Model|null
  {
    $data = Model::find($id);
    if (is_null($data)) {
      return null;
    }

    $data->update($records);
    return $this->getByID($data->id);
  }

  public function totAll($data)
  {
    $keys = isset($data['data']) ? $data['data'] : [['email', '!=', null]];
    return Model::where($keys)->count();
  }

  public function limitFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['created_at', 'asc'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $keys   = isset($data['data'])    ? $data['data'] : [['email', '!=', null]];
    $roles  = isset($data['whith']['roles']) ? $data['whith']['roles'] : [['roles_id', '!=', null]];
    return Model::where(function ($query) use ($search) {
                  $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('username', 'LIKE', "%{$search}%");
                 })
                ->with('roles')
                ->with('pegawai.mentor_bbq.mentor')
                ->where($keys)
                ->whereHas('roles', function($q) use ($roles) {
                  if(!empty($roles)) $q->where($roles);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function countFiltered($data)
  {
    $search = isset($data['search']) ? $data['search'] : '';
    $keys = isset($data['data']) ? $data['data'] : [['email', '!=', null]];
    $roles  = isset($data['whith']['roles']) ? $data['whith']['roles'] : [['roles_id', '!=', null]];
    return Model::where(function ($query) use ($search) {
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('username', 'LIKE', "%{$search}%");
      })
      ->whereHas('roles', function($q) use ($roles) {
        if(!empty($roles)) $q->where($roles);
      })
      ->where($keys)
      ->count();
  }

  public function delete($id): bool
  {
    $data = Model::find($id);
    if (empty($data)) {
      return false;
    }
    
    $data->delete($data);
    return true;
  }

}
