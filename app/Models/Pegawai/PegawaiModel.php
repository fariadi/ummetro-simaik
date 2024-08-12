<?php

namespace App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Ref\WilayahModel;
use App\Models\User as UserMentor;

class PegawaiModel extends Model
{
    use HasFactory;

    protected $table        = 'pegawai';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'id',
        'user_id',
        'nama_lengkap',
        'nbm',
        'ranting_tingkat',
        'ranting_prv_kode',
        'ranting_kab_kode',
        'ranting_kec_kode',
        'ranting_jalan',
        'ranting_desa_kel'
    ];

    protected $hidden = [
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rantingKab()
    {
        return $this->belongsTo(WilayahModel::class, 'ranting_kab_kode', 'kode');
    }

    public function rantingProv()
    {
        return $this->belongsTo(WilayahModel::class, 'ranting_prv_kode', 'kode');
    }

    public function rantingKec()
    {
        return $this->belongsTo(WilayahModel::class, 'ranting_kec_kode', 'kode');
    }

    public function mentor()
    {
        return $this->belongsTo(UserMentor::class, 'mentor_user_id', 'id');
    }

}