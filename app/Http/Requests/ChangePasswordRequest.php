<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        if ($this->filled('new_password') || $this->filled('current_password')) {
            $validator->after(function ($validator) {
                if (! $this->passwordMatches()) {
                    $validator->errors()->add('current_password', __('Contraseña incorrecta.'));
                }
                if ($this->samePassword()) {
                    $validator->errors()
                        ->add('new_password', __('Debe ser una contraseña distinta a la actual.'));
                }
            });
        }
    }

    public function passwordMatches()
    {
        return Hash::check($this->input('current_password'), auth()->user()->password);
    }

    public function samePassword()
    {
        return $this->input('current_password') === $this->input('new_password');
    }
}
