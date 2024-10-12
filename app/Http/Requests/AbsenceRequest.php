<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules['user'] = 'required|exists:users,id';
        $rules['motif'] = 'required|exists:motifs,id';
        $rules['debut'] = 'required|date';
        $rules['fin'] = 'required|date|after:date_debut';

        return $rules;
    }
}
