<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Models\Pegawai\PegawaiModel;

class User extends Authenticatable implements JWTSubject
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $table = 'users';

  protected $primaryKey = 'id';
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'name',
    'username',
    'email',
    'email_verified_at',
    'password',
    'remember_token',
    'jk',
    'tmpt_lahir',
    'tgl_lahir',
    'nm_ibu_kandung',
    'id_agama',
    'nik',
    'kebangsaan',
    'jln',
    'rt',
    'rw',
    'nm_dsn',
    'ds_kel',
    'kode_pos',
    'telepon_seluler',
    'almt_tinggal',
    'foto',
    'lulusan_jenjang',
    'lulusan_asal',
    'lulusan_jurusan',
    'lulusan_tahun',
    'lulusan_ijazah',
    'pekerjaan_nm_lemb',
    'pekerjaan_jabatan',
    'pekerjaan_alamat',
    'pekerjaan_telpn',
    'pekerjaan_fax',
    'pekerjaan_email',
    'pekerjaan_kode_pos',
    'created_at',
    'updated_at',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ['password', 'remember_token'];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier(): string
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims(): array
  {
    return [];
  }

  public function roles()
  {
    return $this->belongsToMany(Roles::class, 'users_roles', 'users_id', 'roles_id');
  }

  public function pegawai()
  {
        return $this->belongsTo(PegawaiModel::class, 'id', 'user_id');
  }

  public function authorizeRoles($roles)
  {
    if ($this->hasAnyRole($roles)) {
      return true;
    }
    abort(401, 'This action is unauthorized.');
  }

  public function hasAnyRole($roles)
  {
    if (is_array($roles)) {
      foreach ($roles as $role) {
        if ($this->hasRole($role)) {
          return true;
        }
      }
    } else {
      if ($this->hasRole($roles)) {
        return true;
      }
    }
    return false;
  }

  public function hasRole($role)
  {
    if (
      $this->roles()
        ->where('name', $role)
        ->first()
    ) {
      return true;
    }
    return false;
  }
}
