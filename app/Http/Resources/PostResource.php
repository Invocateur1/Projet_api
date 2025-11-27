<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @param Request $request
     * 
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            // Données de base du post
            'id' => $this->id,
            'titre' => $this->titre,
            'contenu' => $this->contenu,
            'statut' => $this->statut,

            // Date de publication formatée (peut être null)
            'publie_le' => $this->publie_le?->format('d/m/Y H:i:s'),

            // Informations de l'auteur (relation)
            'auteur' => [
                'id' => $this->user->id,
                'nom' => $this->user->name,
                'email' => $this->user->email,
            ],
        // Timestamps formatés
        'cree_le' => $this->created_at->format('d/m/Y H:i:s'),
        'modifie_le' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
