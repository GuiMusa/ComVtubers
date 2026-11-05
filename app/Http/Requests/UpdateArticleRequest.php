<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Le modèle Article est injecté par route-model-binding
        return $this->user()->can('update', $this->route('article'));
    }

    public function rules(): array
    {
        return [
            'titre'        => ['required', 'string', 'max:255'],
            'contenu'      => ['required', 'string'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'media'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,mp4,mov,avi', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'        => 'Le titre est obligatoire.',
            'contenu.required'      => 'Le message est obligatoire.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'media.mimes'           => 'Le fichier doit être une image ou une vidéo.',
            'media.max'             => 'Le fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}