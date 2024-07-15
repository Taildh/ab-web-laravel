<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'introduce_text' => 'required',
            'introduce_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|numeric',
            'address' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'introduce_text.required' => 'Vui lòng nhập nội dung',
            'introduce_image.image' => 'File được tải lên không phải là file ảnh',
            'introduce_image.mimes' => 'Vui lòng chọn file với định dạng: jpeg, png, jpg',
            'facebook_url.url' => 'Vui lòng nhập vào một url',
            'instagram_url.url' => 'Vui lòng nhập vào một url',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'phone_number.numeric' => 'Vui lòng nhập số',
        ];
    }
}
