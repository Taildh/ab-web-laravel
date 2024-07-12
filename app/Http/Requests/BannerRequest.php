<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'title' => 'required|max:255',
            'short_desc' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function message()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'title.short_desc' => 'Vui lòng nhập tiêu đề phụ',
            'image.image' => 'File được tải lên không phải là file ảnh',
            'image.mimes' => 'Vui lòng chọn file với định dạng: jpeg, png, jpg',
            'image_mobile.image' => 'File được tải lên không phải là file ảnh',
            'image_mobile.mimes' => 'Vui lòng chọn file với định dạng: jpeg, png, jpg',
        ];
    }
}
