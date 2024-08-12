<?php

namespace App\Repositories\Ref;

use Illuminate\Support\Str;
use App\Interfaces\ModelInterface;

use Illuminate\Support\Facades\DB;
use App\Models\Ref\WilayahModel as Model;
use Illuminate\Contracts\Pagination\Paginator;

class WilayahRepository implements ModelInterface
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

  public function totAll($data)
  {
    $keys = isset($data['data']) ? $data['data'] : [['email', '!=', null]];
    return Model::where($keys)->count();
  }

  public function limitFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['kode', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $keys   = isset($data['data'])    ? $data['data'] : [['kode', '!=', null]];
    return Model::where(function ($query) use ($search) {
                  $query->where('kode', 'LIKE', "%{$search}%")
                        ->orWhere('nama', 'LIKE', "%{$search}%");
                 })
                ->where($keys)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function countFiltered($data)
  {
    $search = isset($data['search']) ? $data['search'] : '';
    $keys = isset($data['data']) ? $data['data'] : [['kode', '!=', null]];
    return Model::where(function ($query) use ($search) {
        $query->where('kode', 'LIKE', "%{$search}%")
              ->orWhere('nama', 'LIKE', "%{$search}%");
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


  public function provFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['kode', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    return Model::where(function ($query) use ($search) {
                  $query->where('kode', 'NOT LIKE', "%.%")
                        ->Where('nama', 'LIKE', "%{$search}%");
                 })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function kabFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['kode', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $prov   = isset($data['prov'])    ? $data['prov'] : '';
    return Model::where(function ($query) use ($prov, $search) {
                  $query->where('kode', 'LIKE', "{$prov}.%")
                        ->where('kode', 'NOT LIKE', "{$prov}.%.%")
                        ->Where('nama', 'LIKE', "%{$search}%");
                 })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

  public function kecFiltered($data)
  {
    $order  = isset($data['order'])   ? $data['order'] : ['kode', 'DESC'];
    $limit  = isset($data['limit'])   ? $data['limit'] : 10;
    $start  = isset($data['start'])   ? $data['start'] : -1;
    $search = isset($data['search'])  ? $data['search'] : '';
    $kab    = isset($data['kab'])     ? $data['kab'] : '';
    return Model::where(function ($query) use ($kab, $search) {
                  $query->where('kode', 'LIKE', "{$kab}.%")
                        ->Where('nama', 'LIKE', "%{$search}%");
                 })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order[0], $order[1])
                ->get();
  }

}
