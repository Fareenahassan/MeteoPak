<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->id() == $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'description' => ['nullable', 'string', 'max:1000'],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048', // 2MB max size
            ],
            'region_id' => ['nullable', 'exists:regions,id'],
            'station_id' => ['nullable', 'exists:stations,id'],
            'designation' => ['nullable', 'in:Director General,Chief Meteorologist,Director (Engineering) / Principal Engineer,Director / Principal Meteorologist,Senior Private Secretary,Deputy Director / Senior Meteorologist,Senior Programmer,Deputy Chief Administrative Officer,Sr. Electronic Engineer / Deputy Director (Engineering),Administrative Officer,Meteorologist,Accounts Officer,Librarian,Security Officer,Electronics Engineer,Programmer,Assistant Meteorologist,Superintendent,Assistant Private Secretary,Assistant Programmer,Assistant Mechanical Engineer,Assistant Electronic Engineer,Head Draughtsman,Assistant Ministerial,Data Entry Operator,Meteorological Assistant,Stenotypist,Sub Engineer (Electronics),Sub Engineer (Mechanical),Mechanical Assistant,Draughtsman,Upper Division Clerk,Lower Division Clerk,Senior Observer,Observer'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'personal_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->route('user')),
            ],
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
            'date_of_birth.before' => 'The date of birth must be a date before today.',
            'profile_image.image' => 'The file must be an image.',
            'profile_image.mimes' => 'The image must be a JPEG, PNG, or JPG file.',
            'profile_image.max' => 'The image may not be larger than 2MB.',
            'region_id.exists' => 'The selected region is invalid.',
            'station_id.exists' => 'The selected station is invalid.',
            'designation.in' => 'Please select a valid designation.',
            'gender.in' => 'Please select a valid gender.',
            'personal_number.unique' => 'This personal number is already in use.',
        ];
    }
}