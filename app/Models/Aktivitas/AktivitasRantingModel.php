<?php

namespace App\Models\Aktivitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pegawai\PegawaiModel;

class AktivitasRantingModel extends Model
{
    use HasFactory;

    protected $table        = 'aktivitas_ranting';
    protected $primaryKey   = 'id';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'id',
        'pegawai_id',
        'aktivitas_tanggal',
        'aktivitas_materi'
    ];

    protected $hidden = [
        
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'pegawai_id', 'id');
    }

}