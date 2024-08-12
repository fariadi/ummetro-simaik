<?php

namespace App\Models\Ref;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahModel extends Model
{
    use HasFactory;

    protected $table        = 'wilayah';
    protected $primaryKey   = 'kode';
    protected $keyType      = 'string';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'kode',
        'nama'
    ];

    protected $hidden = [
        
    ];

}