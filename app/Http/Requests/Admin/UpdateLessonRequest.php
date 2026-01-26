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
            'video_provider' => ['required', Rule::enum(VideoProvider::class)],
            'video_ref_id' => 'required|string|max:255',
            'duration_seconds' => 'nullable|integer|min:0',
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
