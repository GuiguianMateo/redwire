<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Summary of rules
     */
    public function rules(): array
    {
        $rules['titre'] = 'required|string|max:30';
        $rules['is_accessible'] = 'required|boolean';

        return $rules;
    }
}
