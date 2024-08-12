<?php

namespace App\Repositories\Aktivitas;

use Illuminate\Support\Str;
use App\Interfaces\ModelInterface;

use Illuminate\Support\Facades\DB;
use App\Models\Aktivitas\AktivitasRantingModel as Model;
use Illuminate\Contracts\Pagination\Paginator;

class AktivitasRantingRepository implements ModelInterface
{
  public function getAll()
  {
    return Model::orderBy('id', 'DESC')->get();
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
    $keys = isset($data['data']) ? $data['data'] : [['pegawai_id', '!=', null]];
    return Model::where($keys)->count();
  }
  
  public function limitFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['id', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $keys   = isset($data['data'])    ? $data['data'] : [['pegawai_id', '!=', null]];
    $pegawai  = isset($data['with']['pegawai'])  ? $data['with']['pegawai'] : null;
    return Model::whereHas('pegawai', function($query) use ($pegawai,$search) {
                  $query->where('nama_lengkap', 'LIKE', "%{$search}%");
                  if($pegawai) $query->where($pegawai);
                })
                ->with('pegawai')
                ->where($keys)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function countFiltered($data)
  {
    $search = isset($data['search']) ? $data['search'] : '';
    $keys   = isset($data['data'])   ? $data['data']   : [['pegawai_id', '!=', null]];
    $pegawai  = isset($data['with']['pegawai'])  ? $data['with']['pegawai'] : null;

    return Model::whereHas('pegawai', function($query) use ($pegawai,$search) {
                    $query->where('nama_lengkap', 'LIKE', "%{$search}%");
                    if($pegawai) $query->where($pegawai);
                  })
                  ->where($keys)
                  ->count();
  }
}