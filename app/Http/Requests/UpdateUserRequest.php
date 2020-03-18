<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:3|max:50',
            'surname' => 'required|string|min:3|max:50',
            'email' => [
                'required',
                'string',
                'email',
                'min:6',
                'max:100',
                Rule::unique('users')->ignore($this->route('user'))
            ],
        ];

        if ($this->filled('password') || $this->filled('current_password')){
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        if ($this->filled('password') || $this->filled('current_password')) {
            $validator->after(function ($validator) {
                if (! $this->passwordMatches()) {
                    $validator->errors()->add('current_password', 'No coincide con la contraseña actual');
                } elseif($this->samePassword()) {
                    $validator->errors()->add('password', 'No puede ser igual que la contraseña actual');
                }
            });
        }
    }

    public function passwordMatches(){
        return Hash::check($this->input('current_password'), auth()->user()->password);
    }

    public function samePassword(){
        return strcmp($this->input('current_password'), $this->input('password')) == 0;
    }
}
