<?php

namespace App\Http\Requests\bbq;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Traits\ResponseTrait;



class MentorStore extends FormRequest
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
      'mentor_user_id'  => 'required',
    ];
  }

  protected function update()
  {
    return [
        'pegawai_id' => 'required',
        'mentor_user_id' => 'required',
    ];
  }

  /**
   * @return array
   * Custom validation message
   */
  public function messages(): array
  {
    return [
      'pegawai_id.required' => 'ID Pegawai tidak boleh kosong',
      'mentor_user_id.required' => 'Mentor tidak boleh kosong',
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
    /*
    $this->merge([
      'password' => Hash::make($this->input('password')),
      'tgl_lahir' => Carbon::createFromFormat('d/m/Y', $this->input('tgl_lahir'))->format('Y-m-d'),
      'jenjang_didik' => \App\Models\Ref\TblJenjangModel::find($this->input('sp_jenjang'))->nm_jenj_didik,
      'sp_nama' => $this->input('sp_jenjang') != '6' ? $this->input('asal_slta') : null,
      'sp_tahun_lulus' => $this->input('sp_jenjang') != '6' ? $this->input('thn_lulus_slta') : null,
      'sp_npm' => $this->input('sp_jenjang') != '6' ? $this->input('nisn') : null,
      'sp_prodi' => $this->input('sp_jenjang') != '6' ? $this->input('nm_prodi_asal_pt') : null,
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
