<?php

namespace App\Http\Requests\aktifitas;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Traits\ResponseTrait;



class RantingStore extends FormRequest
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
      'aktivitas_tanggal'  => 'required',
      'aktivitas_materi'  => 'required',
    ];
  }

  protected function update()
  {
    return [
        'pegawai_id' => 'required',
        'aktivitas_tanggal'  => 'required',
        'aktivitas_materi'  => 'required',
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
      'aktivitas_tanggal.required' => 'Tanggal tidak boleh kosong',
      'aktivitas_materi.required' => 'Ringkasan materi tidak boleh kosong',
    ];
  }

  protected function prepareForValidation(): void
  {
  }

  protected function passedValidation(): void
  {
    $this->merge([
        'aktivitas_tanggal' => Carbon::createFromFormat('d/m/Y', $this->input('aktivitas_tanggal'))->format('Y-m-d'),
    ]);
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
