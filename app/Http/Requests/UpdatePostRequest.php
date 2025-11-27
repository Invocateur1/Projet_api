<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->route('post') = le post du route model binding
        return $this->user()->id === $this->route('post')->user_id;
    }

    /**
        * Règles de validation
        * 'sometimes' = le champ est optionnel mais s'il existe, il doit être valide
    */
    public function rules(): array
    {
        return [
            'titre' => 'sometimes|string|max:255',
            'contenu' => 'sometimes|string|min:10',
            'statut' => 'sometimes|in:brouillon,publie',
        ];
    }
    public function messages(): array
    {
        return [
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
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
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Vous n\'êtes pas autorisé à modifier cet article'
        ], 403));
    }
}
