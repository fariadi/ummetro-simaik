<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('mahasiswa_npm')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->enum('jk', ['L', 'P'])->nullable();
      $table->string('tmpt_lahir', 255)->nullable();
      $table->date('tgl_lahir')->nullable();
      $table->string('nm_ibu_kandung')->nullable();
      $table->integer('id_agama')->nullable();
      $table->string('nik', 20)->nullable();
      $table->string('kebangsaan', 100)->nullable();
      $table->string('jln')->nullable();
      $table->string('rt', 10)->nullable();
      $table->string('rw', 10)->nullable();
      $table->string('nm_dsn')->nullable();
      $table->string('ds_kel')->nullable();
      $table->string('kode_pos', 15)->nullable();
      $table->string('telepon_seluler', 16)->nullable();
      $table->string('almt_tinggal')->nullable();
      $table
        ->enum('lulusan_jenjang', ['SMP/SEDERAJAT', 'SMA/SEDERAJAT', 'D-1', 'D-2', 'D-3', 'S-1', 'S-2', 'S-3'])
        ->nullable();
      $table->string('lulusan_asal')->nullable();
      $table->string('lulusan_jurusan')->nullable();
      $table->string('lulusan_tahun', 5)->nullable();
      $table->string('lulusan_ijazah')->nullable();
      $table->string('pekerjaan_nm_lemb')->nullable();
      $table->string('pekerjaan_jabatan', 180)->nullable();
      $table->string('pekerjaan_alamat')->nullable();
      $table->string('pekerjaan_telpn', 15)->nullable();
      $table->string('pekerjaan_fax', 15)->nullable();
      $table->string('pekerjaan_email')->nullable();
      $table->string('pekerjaan_kode_pos', 10)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
