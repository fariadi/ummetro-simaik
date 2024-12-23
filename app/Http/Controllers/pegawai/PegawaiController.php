<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use App\Models\Aktivitas\AktivitasRantingModel;
use App\Models\Bbq\BbqregModel;
use App\Models\Pegawai\PegawaiModel;
use FPDF;
use Illuminate\Support\Facades\Storage;

use App\Services\HttpSimpeg;
use App\Traits\ResponseTrait;
use File;
use RequestFilterHelper;

class PegawaiController extends Controller
{
  use ResponseTrait;


  public function index(): JsonResponse
  {
    $length = $request->input('length') ? $request->input('length') : 10;
    try {
      $client = new HttpSimpeg();
      $pegawai = $client->request('GET', 'api/pegawai/list', ['limit' => $length]);

      return $this->responseSuccess($pegawai, 'Profile Fetched Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(
    PegawaiRepository $pegawaiRepository,
    $id=null
  ): JsonResponse
  {
    //$client = new HttpSimpeg();
    $data = $pegawaiRepository->getByField(['data' => ['id' => $id]]);
    //$data = $client->token();
    return response()->json($data);
  }

  public function dataTableJson(Request $request)
  {
      $length = $request->input('length') ? $request->input('length') : 10;
      $start = $request->input('start') ? $request->input('start') : 0;
      $search = ($request->input('search')) ? $request->input('search') : '';
      $search = (is_array($search)) ? $search['value'] : $search;
      try {
        $client = new HttpSimpeg();
        $pegawai = $client->request('GET', 'api/pegawai/list', ['limit' => $length, 'offsite' => $start, 'search' => $search]);
      } catch (\Exception $e) {
        return response()->json(
          [
            'messages' => $e->getMessage(),
            'code' => 500,
            'data' => [],
          ],
          Response::HTTP_INTERNAL_SERVER_ERROR
        );
      }
       return  response()->json($pegawai);
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => isset($pegawai->total) ? $pegawai->total : 0,
        'recordsFiltered' => isset($pegawai->totalFilter) ? $pegawai->totalFilter : 0,
        'code' => 200,
        'messages' => 'Ok!.',
        'data' => $pegawai->data,
      ]);
  }

  
  public function donwloadPegawaiId(Request $request, $id)
  {
    $data = PegawaiModel::with('rantingKec')
            ->with('user')
            ->with('rantingKab')
            ->with('rantingProv')
            ->with('rantingKec')
            ->findOrFail($id);
    $aktivitas_ranting = AktivitasRantingModel::with('pegawai')->where('pegawai_id', $data->id)->get();
    $riwayat_hafalan = BbqregModel::with('pegawai')
            ->with('surah')
            ->with('mentor')
            ->where('pegawai_id', $data->id)
            ->get();
        // dd($data->user->foto);
    $kelamin      = $data->user->jk == 'L' ? 'Laki - Laki' : 'Perempuan';
    $nama_ranting =  $data && $data->ranting_tingkat === 'ranting' ? strtoupper($data->ranting_tingkat . ' ' . $data->rantingKec->nama) : '';
    $tingkat      = $data && $data->ranting_tingkat ? strtoupper($data->ranting_tingkat) : 'Tidak ada';
    $provinsi     = $data &&  $data->rantingProv ?  $data->rantingProv->nama : '-';
    $kabupaten    = $data && $data->rantingKab ? $data->rantingKab->nama : '-';
    $kecamatan    = $data && $data->rantingKec ? $data->rantingKec->nama : '-';
    $alamat       = $data && $data->ranting_jalan ? $data->ranting_jalan : '-';
    $desa         = $data && $data->ranting_desa_kel ? $data->ranting_desa_kel : '-';

    // dd($data->user->jk);
    $pdf = new Fpdf();
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('Arial', 'B', 10);
        //profile
    $pdf->Cell(137, 10, 'Profile', 'LTR', 1,);
    $imgaeFile = ($data->user->foto) ? $data->user->foto : 'images/user/aik/exsample.jpg';
    if(!Storage::disk('public')->exists($imgaeFile)){
      $imgaeFile = 'images/user/aik/exsample.jpg';
    }
    $extension = pathinfo(public_path($imgaeFile), PATHINFO_EXTENSION);
    $pdf->Image(public_path($imgaeFile), 149, 10, 40, 47, $extension);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(27, 6, 'Nama Lengkap', 'LTRB', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6,  $data->nama_lengkap, 'TRB', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 6, 'Nbm', 'LRB', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6, $data->nbm, 'RB', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 6, 'Kelamin', 'LRB', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6,    $kelamin, 'RB', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 6, 'Alamat', 'LRB', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6,   $data->user->jln, 'RB', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 6, 'No. HP', 'LRB', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6,  $data->user->telepon_seluler, 'RB', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(27, 6, 'Email', 'LBR', 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(110, 6,   $data->user->email, 'RB', 1);
    //$pdf->Cell(40, 6, $pdf->Image(public_path("storage/public/".$imgaeFile), $pdf->GetX(), $pdf->GetY(), 33.78), 'LBR', 1);

        //end profile
    $pdf->Ln(5);
        // informasi ranting
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('180', 10, 'Informasi Ranting', 'LTR', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Nama Ranting', 'LTRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $nama_ranting, 'RTB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Tingkat', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $tingkat, 'RDB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Provinsi', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $provinsi, 'RDB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Kabupaten', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $kabupaten, 'RDB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Kecamatan', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $kecamatan, 'RDB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Alamat', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $alamat, 'RDB', 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(27, 8, 'Desa/Kelurahan', 'LRB', 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(153, 8,  $desa, 'RDB', 1);
        // end informasi ranting
        $pdf->Ln(5);
        //aktivitas ranting
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, 10, 'Aktivitas Ranting', 1, 1);
        $pdf->SetFontSize(8);
        $pdf->Cell(7, 8, 'No', 1, 0, 'C');
        $pdf->Cell(27, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tempat', 1, 0, 'C');
        $pdf->Cell(116, 8, 'Materi', 1, 1, 'C');

        $no = 1;
        foreach ($aktivitas_ranting as $aktivitas) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(7, 7, $no, 1, 0, 'C');
            $pdf->Cell(27, 7, $aktivitas->aktivitas_tanggal, 1, 0);
            $pdf->Cell(30, 7, $aktivitas->aktivitas_tempat, 1, 0);
            $pdf->Cell(116, 7, $aktivitas->aktivitas_materi, 1, 1);

            $no++;
        }
        //end aktifitas ranting
        $pdf->Ln(5);
        //riwayat hafalan
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, 10, 'Riwayat Hafalan', 1, 1);
        $pdf->SetFontSize(8);
        $pdf->Cell(7, 8, 'No', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nama Surat', 1, 0, 'C');
        $pdf->Cell('25', 8, 'Ayat', 1, 0, 'C');
        $pdf->Cell(45, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Mentor', 1, 0, 'C');
        $pdf->Cell(33, 8, 'Validasi', 1, 1, 'C');

        $no_riwayat = 1;
        foreach ($riwayat_hafalan as $riwayat) {
            // dd($riwayat->surah->nama_surat);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(7, 7, $no_riwayat, 1, 0, 'C');
            $pdf->Cell(40, 7, $riwayat->surah->nama_surat, 1, 0);
            $pdf->Cell(25, 7, $riwayat->mulai_ayat_ke . 'to' . $riwayat->sampai_ayat_ke, 1, 0);
            $pdf->Cell(45, 7, $riwayat->mentor_jadwal, 1, 0);
            $pdf->Cell(30, 7, $riwayat->mentor->name, 1, 0);
            $pdf->Cell(33, 7, $riwayat->mentor_validasi, 1, 1);

            $no_riwayat++;
        }
        //end riwayat hafalan

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'mahasiswa.pdf');
  }

}