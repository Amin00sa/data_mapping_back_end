<?php

namespace App\Http\Requests;

use App\Enums\TypeDataEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExternalDataBaseStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'entries' => ['required', 'array'],
            'entries.*.name' => ['required', 'string'],
            'entries.*.type' => ['required', new Enum(TypeDataEnum::class)]
        ];
    }
}
