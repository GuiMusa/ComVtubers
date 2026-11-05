<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Article::class);
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
            'titre.max'             => 'Le titre ne doit pas dépasser 255 caractères.',
            'contenu.required'      => 'Le message est obligatoire.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.exists'   => 'La catégorie choisie est invalide.',
            'media.mimes'           => 'Le fichier doit être une image (jpg, png, gif) ou une vidéo (mp4, mov, avi).',
            'media.max'             => 'Le fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}