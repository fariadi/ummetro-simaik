<?php

namespace App\Repositories\Pegawai;

use Illuminate\Support\Str;
use App\Interfaces\ModelInterface;

use Illuminate\Support\Facades\DB;
use App\Models\Pegawai\PegawaiModel as Model;
use Illuminate\Contracts\Pagination\Paginator;

class BiodataRepository implements ModelInterface
{
  public function getAll()
  {
    return Model::orderBy('kode', 'DESC')->get();
  }

  public function getByID($id): Model|null
  {
    return Model::find($id);
  }

  public function create(array $data): Model
  {
    return Model::create($data);
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

  public function delete($id): bool
  {
    $data = Model::find($id);
    if (empty($data)) {
      return false;
    }
    
    $data->delete($data);
    return true;
  }

  public function totAll($data)
  {
    $keys = isset($data['data']) ? $data['data'] : [['nama_lengkap', '!=', null]];
    return Model::where($keys)->count();
  }
  
  public function firstWithUser($id)
  {
    return Model::whereHas('user', function($query) use ($id) {
                    $query->where('id', $id);
                })
                ->with('rantingKab')
                ->with('rantingProv')
                ->with('rantingKec')
                ->first();
  }

  public function limitFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['id', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $keys   = isset($data['data'])    ? $data['data'] : [['nama_lengkap', '!=', null]];
    $user   = isset($data['with']['user'])  ? $data['with']['user'] : null;
    return Model::where(function ($query) use ($search) {
                  $query->where('nama_lengkap', 'LIKE', "%{$search}%");
                 })
                ->where($keys)
                ->whereHas('user', function($query) use ($user) {
                    if($user) $query->where($user);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function countFiltered($data)
  {
    $search = isset($data['search']) ? $data['search'] : '';
    $keys = isset($data['data']) ? $data['data'] : [['nama_lengkap', '!=', null]];
    $user   = isset($data['with']['user'])  ? $data['with']['user'] : null;
    return Model::where(function ($query) use ($search) {
        $query->where('nama_lengkap', 'LIKE', "%{$search}%");
      })
      ->where($keys)
      ->whereHas('user', function($query) use ($user) {
        if($user) $query->where($user);
      })
      ->where($keys)
      ->count();
  }
}
