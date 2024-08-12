<?php

namespace App\Http\Requests\bbq;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Traits\ResponseTrait;

use App\Models\Bbq\MentorModel;

class PertemuanStore extends FormRequest
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
      'pegawai_id' => 'required|string',
      'surat_id'  => 'required',
      'mulai_ayat_ke'  => 'required',
      'sampai_ayat_ke'  => 'required',
      'mentor_user_id' => 'required',
    ];
  }

  protected function update()
  {
    return [
        'mentor_jadwal' => 'required',
        'mentor_lokasi'  => 'required',
        'mentor_jam' => 'required',
    ];
  }

  /**
   * @return array
   * Custom validation message
   */
  public function messages(): array
  {
    return [
      'mentor_jadwal.required' => 'Tanggal tidak boleh kosong',
      'mentor_lokasi.required' => 'Lokasi tidak boleh kosong',
      'mentor_jam.required' => 'Waktu tidak boleh kosong',
    ];
  }

  protected function prepareForValidation(): void
  {
    /*
    $rowEmail = explode("@",$this->input('email'));
    $setUserName = (isset($rowEmail[0])) ? $rowEmail[0] : null;
    $this->merge([
      'mahasiswa_npm' => ($this->input('username_sso')) ? $this->input('username_sso') : null,
      'username' => ($this->input('username_sso')) ? $this->input('username_sso') : $setUserName,
    ]);
    */
  }

  protected function passedValidation(): void
  {
    $jadwal = $this->input('mentor_jadwal') . ' '. $this->input('mentor_jam');
    $this->merge([
        'mentor_jadwal' => Carbon::createFromFormat('d/m/Y H:i:s', $jadwal)->format('Y-m-d H:i:s')
    ]);
    /*
    $this->merge([
      'password' => Hash::make($this->input('password')),
      'tgl_lahir' => Carbon::createFromFormat('d/m/Y', $this->input('tgl_lahir'))->format('Y-m-d'),
      'jenjang_didik' => \App\Models\Ref\TblJenjangModel::find($this->input('sp_jenjang'))->nm_jenj_didik,
    ]);
    */
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
