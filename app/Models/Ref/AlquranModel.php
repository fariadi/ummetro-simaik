<?php

namespace App\Models\Ref;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlquranModel extends Model
{
    use HasFactory;

    protected $table        = 'alquran';
    protected $primaryKey   = 'id';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'id',
        'nama_surat',
        'surat_ke',
        'jumlah_ayat'
    ];

    protected $hidden = [
        
    ];

}