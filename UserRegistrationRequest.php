<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegistrationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'personal_number' => ['required', 'string', 'max:255', 'unique:users,personal_number'],
            'region_id' => ['required', 'exists:regions,id'],
            'station_id' => ['required', 'exists:stations,id'],
            'designation' => ['required', 'in:Director General,Chief Meteorologist,Director (Engineering) / Principal Engineer,Director / Principal Meteorologist,Senior Private Secretary,Deputy Director / Senior Meteorologist,Senior Programmer,Deputy Chief Administrative Officer,Sr. Electronic Engineer / Deputy Director (Engineering),Administrative Officer,Meteorologist,Accounts Officer,Librarian,Security Officer,Electronics Engineer,Programmer,Assistant Meteorologist,Superintendent,Assistant Private Secretary,Assistant Programmer,Assistant Mechanical Engineer,Assistant Electronic Engineer,Head Draughtsman,Assistant Ministerial,Data Entry Operator,Meteorological Assistant,Stenotypist,Sub Engineer (Electronics),Sub Engineer (Mechanical),Mechanical Assistant,Draughtsman,Upper Division Clerk,Lower Division Clerk,Senior Observer,Observer'],
            'gender' => ['required', 'in:Male,Female,Other'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email address is already registered.',
            'personal_number.unique' => 'This personal number is already in use.',
            'region_id.exists' => 'The selected region is invalid.',
            'station_id.exists' => 'The selected station is invalid.',
            'designation.in' => 'Please select a valid designation.',
            'gender.in' => 'Please select a valid gender.',
        ];
    }
}