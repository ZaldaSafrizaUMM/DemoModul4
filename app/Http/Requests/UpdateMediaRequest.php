<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mediaId = $this->route('media')->id ?? $this->route('media');

        return [
            'title' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('media', 'title')->ignore($mediaId),
            ],
            'type' => 'sometimes|string|in:Movie,Series,Anime,Documentary',
            'genre' => 'sometimes|string|max:100',
            'release_year' => 'sometimes|integer|min:1900|max:2030',
            'synopsis' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Judul media sudah digunakan oleh media lain.',
            'type.in' => 'Jenis media harus berupa: Movie, Series, Anime, atau Documentary.',
        ];
    }
}