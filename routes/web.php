<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\ApiController;
use App\Http\Controllers\authentications\AuthController;
use App\Http\Controllers\authentications\UsersController;
use App\Http\Controllers\authentications\GoogleController;

use App\Http\Controllers\services\KepegawaianController;

use App\Http\Controllers\pegawai\PegawaiController;
use App\Http\Controllers\pegawai\BiodataController;
use App\Http\Controllers\bbq\BbqregController;
use App\Http\Controllers\bbq\MentorController;
use App\Http\Controllers\ref\WilayahController;
use App\Http\Controllers\ref\AlquranController;
use App\Http\Controllers\aktivitas\AktivitasRantingController;

use App\Http\Controllers\pages\LoginPage;
use App\Http\Controllers\pages\RegisterPage;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\FrontPage;
use App\Http\Controllers\pages\AdminPage;
use App\Http\Controllers\pages\MentorPage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

Route::post('/forgot-password', function (Request $request) {
  $request->validate(['email' => 'required|email']);
  $status = Password::sendResetLink($request->only('email'));

  return $status === Password::RESET_LINK_SENT
    ? back()->with(['status' => __($status)])
    : back()->withErrors(['email' => __($status)]);
})
  ->middleware('guest')
  ->name('password.email');

// authentication
Route::get('/auth/login', [LoginPage::class, 'index'])->name('auth-login');
Route::get('/auth/forgot', [LoginPage::class, 'forgot'])->name('auth-forgot');

Route::get('/auth/register', [RegisterPage::class, 'index'])->name('auth-register');
Route::get('/auth/register/sdm', [RegisterPage::class, 'sdm'])->name('auth-register-sdm');
Route::get('/auth/register/clear', [RegisterPage::class, 'clearPage'])->name('auth-register-clear');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth-logout');
Route::get('/auth/reset-password/{token}', function (string $token) {
  return view('content.authentications.auth-reset-rpl', ['token' => $token, 'pageConfigs' => ['myLayout' => 'blank']]);
})->middleware('guest')->name('password.reset');
Route::get('/auth/google', [GoogleController::class, 'redirectToProvider'])->name('auth-google-redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleProviderCallback'])->name('auth-google-callback');

Route::get('/', [HomePage::class,'index'])
  ->middleware(['role:admin,peserta'])
  ->name('pages-home');


Route::get('/home', [FrontPage::class,'index'])->middleware(['peserta'])->name('home');
Route::get('/mentor', [MentorPage::class,'index'])->middleware(['role:admin,asesor'])->name('page.asesor');
Route::get('/front/password', [FrontPage::class,'password'])->middleware(['role:admin,peserta'])->name('front.password');
Route::get('/front/ranting', [FrontPage::class,'rantingEdit'])->middleware(['peserta'])->name('front.ranting');
Route::get('/front/bbq/create', [FrontPage::class,'bbqFormAdd'])->middleware(['peserta'])->name('front.bbq.create');

Route::get('/dashboard', [AdminPage::class,'index'])->middleware(['role:admin'])->name('dashboard');
Route::get('/users', [AdminPage::class, 'users'])->middleware(['role:admin'])->middleware(['role:admin'])->name('pages.users');
Route::get('/page/wilayah', [AdminPage::class, 'refWilayah'])->middleware(['role:admin'])->name('page.wilayah');
Route::get('/page/alquran', [AdminPage::class, 'refAlquran'])->middleware(['role:admin'])->name('page.alquran');
Route::get('/page/pegawai', [AdminPage::class, 'pegawai'])->middleware(['role:admin'])->name('page.pegawai');
Route::get('/page/pegawai/{id}', [AdminPage::class, 'pegawaiDetail'])->middleware(['role:admin'])->name('page.pegawai.id');
Route::get('/page/pegawai/{id}/create', [AdminPage::class, 'pegawaiCreate'])->middleware(['role:admin'])->name('page.pegawai.id.create');
Route::get('/page/hafalan-surah', [AdminPage::class, 'pegawai'])->middleware(['role:admin'])->name('page.hafalan-surah');

Route::post('/auth/pratinjau', [AuthController::class, 'pratinjauRegister'])->name('auth-pratinjau-create');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth-create');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate'])->name('auth-authenticate');
Route::post('/auth/simpeg/authenticate', [ApiController::class, 'simpegAuth'])->name('auth-sso-authenticate');
Route::post('/auth/forgot', [AuthController::class, 'sendMailForget'])->middleware('guest')->name('post.password.email');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
Route::post('/auth/peserta/authenticate', [AuthController::class, 'loginAsPeserta'])->middleware(['role:admin'])->name('auth.loginas-peserta');
Route::post('/json/user/photo', [UsersController::class,'upload'])->middleware(['role:admin,peserta,asesor'])->name('post.json.users.foto');
Route::post('/json/alquran', [AlquranController::class, 'store'])->middleware(['role:admin'])->name('post.json.alquran');
Route::post('/json/bbq', [BbqregController::class, 'store'])->middleware(['role:admin,peserta'])->name('post.json.bbq');
Route::post('/json/mentor', [MentorController::class, 'store'])->middleware(['role:admin'])->name('post.json.mentor');
Route::post('/json/aktifitas-ranting', [AktivitasRantingController::class, 'store'])->middleware(['role:admin,peserta,asesor'])->name('post.json.aktifitas-ranting');

Route::get('/json/pegawai', [PegawaiController::class, 'index'])->middleware(['role:admin'])->name('get.json.pegawai');
Route::get('/json/pegawai/{id}', [PegawaiController::class, 'show'])->middleware(['role:admin'])->name('get.json.pegawai.show');
Route::get('/json/users/{id}', [UsersController::class, 'show'])->middleware(['role:admin'])->name('get-json-user-show');
Route::get('/json/wil/prov', [WilayahController::class, 'prov'])->middleware(['peserta'])->name('get.json.wil.prop');
Route::get('/json/wil/kab', [WilayahController::class, 'kabupaten'])->middleware(['peserta'])->name('get.json.wil.kab');
Route::get('/json/wil/kec', [WilayahController::class, 'kecamatan'])->middleware(['peserta'])->name('get.json.wil.kec');
Route::get('/json/alquran/{id}', [AlquranController::class, 'show'])->middleware(['role:admin,peserta'])->name('get.json.alquran.id');

Route::put('/json/pegawai/{id}/ranting', [BiodataController::class, 'rantingUpdate'])->middleware(['role:admin,peserta,asesor'])->name('put.json.pegawai.id.ranting');
Route::put('/json/users/{id}/role', [UsersController::class, 'updateRoles'])->middleware(['role:admin'])->name('put.json.users.role');
Route::put('/json/alquran/{id}', [AlquranController::class, 'update'])->middleware(['role:admin'])->name('put.json.alquran.id');
Route::put('/json/mentor/{id}', [MentorController::class, 'update'])->middleware(['role:admin'])->name('put.json.mentor.id');
Route::put('/json/mentor/{id}/pertemuan', [BbqregController::class, 'pertemuanUpdate'])->middleware(['role:admin,asesor'])->name('put.json.bbq.id.pertemuan');

Route::delete('/json/users/{id}', [UsersController::class, 'destroy'])->middleware(['role:admin'])->name('delete.users');
Route::delete('/json/alquran/{id}', [AlquranController::class, 'destroy'])->middleware(['role:admin'])->name('delete.alquran.id');
Route::delete('/json/bbq/{id}', [BbqregController::class, 'destroy'])->middleware(['role:admin,peserta'])->name('delete.bbq.id');

Route::get('/dataTableJson/wilayah', [WilayahController::class, 'dataTableJson'])->middleware(['role:admin'])->name('dt-table.wilayah');
Route::get('/dataTableJson/alquran', [AlquranController::class, 'dataTableJson'])->middleware(['role:admin,peserta'])->name('dt-table.alquran');
Route::get('/dataTableJson/users', [UsersController::class, 'dataTableJson'])->middleware(['role:admin'])->name('dt-table.users');
Route::get('/dataTableJson/pegawai', [PegawaiController::class, 'dataTableJson'])->middleware(['role:admin'])->name('dt-table.pegawai');
Route::get('/dataTableJson/bbq-pengajuan', [BbqregController::class, 'dataTableJson'])->middleware(['role:admin,peserta,asesor'])->name('dt-table.bbq-pengajuan');


Route::get('kepegawaian/{path}', [KepegawaianController::class,'apiGet'])->where('path', '.+')->middleware(['auth']);
Route::post('kepegawaian/{path}', [KepegawaianController::class,'apiPost'])->where('path', '.+')->middleware(['auth']);