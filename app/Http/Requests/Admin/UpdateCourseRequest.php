<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'category_id' => 'nullable|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'course_video' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:204800',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título do curso é obrigatório.',
            'title.max' => 'O título deve ter no máximo 255 caracteres.',
            'cover_image.image' => 'O arquivo deve ser uma imagem.',
            'cover_image.mimes' => 'A imagem deve ser JPEG, PNG, JPG ou WebP.',
            'cover_image.max' => 'A imagem deve ter no máximo 2MB.',
        ];
    }
}
