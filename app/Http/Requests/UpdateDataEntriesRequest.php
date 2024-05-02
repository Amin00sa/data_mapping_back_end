<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataEntriesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'dataEntries'         => ['required', 'array'],
            'dataEntries.*.id'    => ['nullable', 'uuid', 'exists:data_entries,id'],
            'dataEntries.*.value' => ['nullable', 'string'],
        ];
    }
}
