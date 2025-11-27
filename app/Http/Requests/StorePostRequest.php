<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
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
        return [
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string|min:10',
            'statut' => 'sometimes|in:brouillon,publie',
        ];
    }
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre de l\'article est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'contenu.required' => 'Le contenu de l\'article est obligatoire',
            'contenu.min' => 'Le contenu doit contenir au moins 10 caractères',
            'statut.in' => 'Le statut doit être "brouillon" ou "publie"',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erreurs de validation',
            'errors' => $validator->errors()
        ], 422));
    }
}
