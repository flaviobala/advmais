<?php

namespace App\Http\Requests\Admin;

use App\Enums\VideoProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'video_provider' => ['nullable', Rule::enum(VideoProvider::class), 'required_without:attachment'],
            'video_ref_id' => ['nullable', 'string', 'max:255', 'required_without:attachment'],
            'duration_seconds' => 'nullable|integer|min:0',
            'attachment' => 'nullable|file|mimes:mp4,webm,ogg,pdf,zip,docx|max:204800',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título da aula é obrigatório.',
            'order.required' => 'A ordem da aula é obrigatória.',
            'video_provider.required' => 'O provedor de vídeo é obrigatório.',
            'video_ref_id.required' => 'O ID do vídeo é obrigatório.',
        ];
    }
}
