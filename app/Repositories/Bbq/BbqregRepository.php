<?php

namespace App\Repositories\Bbq;

use Illuminate\Support\Str;
use App\Interfaces\ModelInterface;

use Illuminate\Support\Facades\DB;
use App\Models\Bbq\BbqregModel as Model;
use Illuminate\Contracts\Pagination\Paginator;

class BbqregRepository implements ModelInterface
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
    $surah  = isset($data['with']['surah'])  ? $data['with']['surah'] : null;
    return Model::whereHas('surah', function($query) use ($surah,$search) {
                  $query->where('nama_surat', 'LIKE', "%{$search}%");
                  if($surah) $query->where($surah);
                })
                ->with('surah')
                ->with('pegawai')
                ->with('mentor')
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
    $surah  = isset($data['with']['surah'])  ? $data['with']['surah'] : null;
      return Model::whereHas('surah', function($query) use ($surah,$search) {
        $query->where('nama_surat', 'LIKE', "%{$search}%");
        if($surah) $query->where($surah);
      })
      ->where($keys)
      ->count();
  }
}