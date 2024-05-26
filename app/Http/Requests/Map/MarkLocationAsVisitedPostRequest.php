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
            'files.*.image' => trans('validation.image'),
            'files.*.mimes' => trans('validation.mimes', ['attribute' => 'files', 'values' => 'jpeg,png,jpg,gif']),
            'files.*.max' => trans('validation.max.file', ['attribute' => 'files', 'max' => 1024]),
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
