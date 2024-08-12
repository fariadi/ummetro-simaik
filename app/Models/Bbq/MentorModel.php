<?php

namespace App\Models\Bbq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User as UserMentor;

class MentorModel extends Model
{
    use HasFactory;

    protected $table        = 'bbq_mentor';
    protected $primaryKey   = 'id';

    public $incrementing    = false;
    public $timestamps      = false;

    protected $fillable     = [
        'pegawai_id',
        'mentor_user_id'
    ];

    protected $hidden = [
        
    ];


    public function mentor()
    {
        return $this->belongsTo(UserMentor::class, 'mentor_user_id', 'id');
    }

}