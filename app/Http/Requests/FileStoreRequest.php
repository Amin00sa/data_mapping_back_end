<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FileStoreRequest extends FormRequest
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
            'files' => ['required'],
            'files.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $file = $value;
                    $extensions = ['csv', 'xml', 'xls', 'xlsx', 'sql'];
                    $allowedExtensions = ['csv', 'xml', 'xls', 'xlsx', 'txt'];

                    if (!in_array($file->extension(), $allowedExtensions) || pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) !== 'sql') {
                        $fail("The {$attribute} must be a file of type: " . implode(', ', $extensions) . ".");
                    }
                }
            ],
        ];
    }
}
