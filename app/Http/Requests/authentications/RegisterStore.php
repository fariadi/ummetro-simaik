<?php

namespace App\Http\Requests\authentications;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Traits\ResponseTrait;

class RegisterStore extends FormRequest
{
  use ResponseTrait;

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [] + ($this->isMethod('POST') ? $this->store() : ($this->isMethod('PUT') ? $this->update() : $this->view()));
  }

  protected function store()
  {
    return [
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|min:6',
    ];
    /*
        return [
            'id_sms'          => 'required',
            'id_sp'           => 'required',
            'id_jns_daftar'   => 'required',
            'nipd'            => 'required|unique:tbl_mhs',
            'tgl_masuk_sp'    => 'required',
            'nm_pd'           => 'required',
            'jk'              => 'required',
            'tmpt_lahir'      => 'required',
            'tgl_lahir'       => 'required',
            'id_agama'        => 'required',
            'mulai_smt'       => 'required',
            'id_wil'          => 'required',
            'a_terima_kps'    => 'required',
            'paket'           => 'required',
            'a_pernah_paud'   => 'required',
            'nm_ibu_kandung'  => 'required',
            'kewarganegaraan' => 'required',
            'id_kebutuhan_khusus_ayah'      => 'required',
            'id_kebutuhan_khusus_ibu'       => 'required',    
        ];
      */
  }

  protected function update()
  {
    return [];
    /*
        return [
            'thn_akad'      => 'required',
            'smt_akad'      => 'required',
            'thn_smt'       => 'required',
            'angsur_ke'     => 'required',
            'smt_mhs'       => 'required',
        ];
        */
  }

  /**
   * @return array
   * Custom validation message
   */
  public function messages(): array
  {
    return [
      'email.unique' => 'email :input sudah ada',
    ];
    /*
        return [
            'id_reg_pd.required'        => 'Field id_reg_pd tidak boleh kosong',
            'thn_akad.required'         => 'Field thn_akad tidak boleh kosong',
            'smt_akad.required'         => 'Field smt_akad tidak boleh kosong',
            'thn_smt.required'          => 'Field thn_smt tidak boleh kosong',
            'kredit.required'           => 'Field kredit tidak boleh kosong',
            'smt_mhs.required'          => 'Field smt_mhs tidak boleh kosong',
            'key_tagihan.required'      => 'Field key_tagihan tidak boleh kosong',
            'key_tagihan.unique'        => 'key_tagihan :input sudah ada',
        ];
        */
  }

  protected function prepareForValidation(): void
  {
    /*
    $password = date('y') . mt_rand(1000, 9999);
    */
    $rowEmail = explode("@",$this->input('email'));
    $setUserName = (isset($rowEmail[0])) ? $rowEmail[0] : null;
    $this->merge([
      'username' => ($this->input('username_sso')) ? $this->input('username_sso') : $setUserName,
    ]);
  }

  protected function passedValidation(): void
  {
    $this->merge([
      'password' => Hash::make($this->input('password')),
      'tgl_lahir' => Carbon::createFromFormat('d/m/Y', $this->input('tgl_lahir'))->format('Y-m-d'),
    ]);
    /*
    $this->merge([
      'jenjang_didik' => \App\Models\Ref\TblJenjangModel::find($this->input('sp_jenjang'))->nm_jenj_didik,
      'sp_nama' => $this->input('sp_jenjang') != '6' ? $this->input('asal_slta') : null,
      'sp_tahun_lulus' => $this->input('sp_jenjang') != '6' ? $this->input('thn_lulus_slta') : null,
      'sp_npm' => $this->input('sp_jenjang') != '6' ? $this->input('nisn') : null,
      'sp_prodi' => $this->input('sp_jenjang') != '6' ? $this->input('nm_prodi_asal_pt') : null,
    ]);
    */
  }

  public function withValidator( Validator $validator )
  {
    $pegawaiId = $this->input('pegawai_id');
    $pegawai = \App\Models\Pegawai\PegawaiModel::where([['id', '=', $pegawaiId]])->first();
    $validator->after(function ($validator) use ($pegawai) {
      if($pegawai) {
        $validator->errors()->add(
            'pegawai', 'Data sudah ada!'
        );
        return;
      }
    });
  }

  protected function failedValidation(Validator $validator)
  {
    $errors = (new ValidationException($validator))->errors();
    $errorsMsg = '';

    foreach ($errors as $field => $error):
      $errorsMsg .= implode(' ', $error) . ". \n";
    endforeach;

    throw new HttpResponseException($this->responseError($errors, $errorsMsg));
  }
}
