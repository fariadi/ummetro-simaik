<?php

namespace App\Models\Bbq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ref\AlquranModel;
use App\Models\Pegawai\PegawaiModel;
use App\Models\User as UserMentor;

class BbqregModel extends Model
{
    use HasFactory;

    protected $table        = 'bbq_registrasi';
    protected $primaryKey   = 'id';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'pegawai_id',
        'surat_id',
        'mulai_ayat_ke',
        'sampai_ayat_ke',
        'pengajuan_tanggal',
        'mentor_user_id',
        'mentor_jadwal',
        'mentor_lokasi',
        'mentor_validasi'
    ];

    protected $hidden = [
        
    ];


    public function surah()
    {
        return $this->belongsTo(AlquranModel::class, 'surat_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'pegawai_id', 'id');
    }

    public function mentor()
    {
        return $this->belongsTo(UserMentor::class, 'mentor_user_id', 'id');
    }
}