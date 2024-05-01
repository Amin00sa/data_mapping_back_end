<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MappingStoreRequest extends FormRequest
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
            'object' => ['required', 'array'],
            'object.*.entryId' => ['required', 'uuid', 'exists:entries,id'],
            'object.*.header' => ['required', 'string'],
            'fileId' => ['required', 'uuid', 'exists:files,id'],
        ];
    }
}
