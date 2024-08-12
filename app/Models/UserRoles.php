<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
  use HasFactory;

  protected $table = 'users_roles';
  protected $primaryKey = 'id';

  //public $timestamps      = false;

  protected $fillable = ['id', 'users_id', 'roles_id'];
}
