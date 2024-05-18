<?php

namespace App\Http\Requests\Map;

use App\Http\Requests\MainFormRequest;
use Carbon\Carbon;

class MarkLocationAsVisitedPostRequest extends MainFormRequest
{
    public function rules(): array
    {
        return [
            'visited_at' => 'date',
            'files' => 'array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'files.*.image' => 'The uploaded file must be an image.',
            'files.*.mimes' => 'Only JPEG, PNG, JPG, and GIF files are allowed.',
            'files.*.max' => 'The uploaded file may not be greater than 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('visited_at')) {
            $this->merge([
                'visited_at' => Carbon::createFromFormat('M d, Y', $this->input('visited_at')),
            ]);
        }
    }
}
