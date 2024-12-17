<?php

namespace App\Repositories\Bbq;

use Illuminate\Support\Str;
use App\Interfaces\ModelInterface;

use Illuminate\Support\Facades\DB;
use App\Models\Bbq\BbqregModel as Model;
use App\Models\Pegawai\PegawaiModel;
use Illuminate\Contracts\Pagination\Paginator;

class BbqregRepository implements ModelInterface
{
  public function getAll()
  {
    return Model::orderBy('kode', 'DESC')->get();
  }

  public function getByID($id): Model|null
  {
    return Model::with('pegawai')->with('surah')->find($id);
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
    return Model::whereHas('pegawai', function($query) use ($surah,$search) {
                  $query->where('nama_lengkap', 'LIKE', "%{$search}%");
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

  public function countPegawaiSurat($data = [])
  {
        // $startOut = (isset($data['tanggal']['start_out'])) 
        //                 ? Carbon::createFromFormat('Y-m-d', $data['tanggal']['start_out'])
        //                 : Carbon::createFromFormat('Y-m-d', '2016-01-01');
        // $endOut   = (isset($data['tanggal']['end_out'])) 
        //                 ? Carbon::createFromFormat('Y-m-d', $data['tanggal']['end_out'])
        //                 : Carbon::now();
        // $tglNow = Carbon::now();
        // $mulai  = date('Y', strtotime("-8 year", strtotime($tglNow)));
        $keys   = (isset($data['data']))   ? $data['data']   : [['user_id', '!=', NULL]];
        
        return PegawaiModel::select('id', 'nbm', 'nama_lengkap')
                         ->where($keys)
                         /*->where('stat_prodi', 'A')*/
                         ->addSelect(['ajuan' => Model::select(DB::raw('count(pegawai_id)'))
                            ->whereColumn('pegawai_id', 'pegawai.id')
                            /*
                            ->whereNull('id_jns_keluar')
                            ->where('stat_pd', '=', 'A')
                            ->where('mulai_smt', '>=', $mulai.'1')
                            */
                         ])
                         ->addSelect(['divalidasi' => Model::select(DB::raw('count(pegawai_id)'))
                            ->whereColumn('pegawai_id', 'pegawai.id')
                            ->whereNotNull('mentor_validasi')
                         ])
                         /*
                         ->addSelect(['nonaktif' => Model::select(DB::raw('count(id_sms)'))
                            ->whereColumn('id_sms', 'tbl_sms.id_sms')
                            ->where('id_jns_keluar', '3')
                            ->where(function ($q) use ($startOut,$endOut) {
                                $q->whereBetween('tgl_keluar', [$startOut, $endOut]);
                            })
                         ])
                         */
                         ->get();
  }
}