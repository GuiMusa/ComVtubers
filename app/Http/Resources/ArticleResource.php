<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'titre'     => $this->titre,
            'contenu'   => $this->contenu,
            'status'    => $this->status,
            'date'      => $this->date,

            // URL complète prête à consommer (image ou vidéo)
            'media_url' => $this->media ? asset('storage/' . $this->media) : null,
            'media_type' => $this->media
                ? (in_array(strtolower(pathinfo($this->media, PATHINFO_EXTENSION)),
                    ['mp4','mov','avi']) ? 'video' : 'image')
                : null,

            'favoris'   => (bool) $this->favoris,

            'auteur' => $this->whenLoaded('user', fn () => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ]),

            'categorie' => $this->whenLoaded('categorie', fn () => [
                'id'  => $this->categorie->id,
                'nom' => $this->categorie->nom,
            ]),

            'commentaires_count' => $this->whenLoaded('commentaires', fn () => $this->commentaires->count()),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}