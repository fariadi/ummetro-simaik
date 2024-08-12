<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table        = 'simaru.roles';
    protected $primaryKey   = 'id';
    
    public $timestamps      = false;

    protected $fillable     = [
        'id',
        'name',
        'description'
    ];

}