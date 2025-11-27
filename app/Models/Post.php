<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'contenu',
        'statut',
        'publie_le',
        'user_id'
    ];
    protected $casts = [
        'publie_le' => 'datetime', // Convertir en objet Carbon
    ];
    // ==========================================
    // RELATIONS ELOQUENT
    // ==========================================

    /**
        * Un post appartient à un utilisateur (Many-to-One)
        *
        * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // ==========================================
    // SCOPES (Requêtes réutilisables)
    // ==========================================

    /**
        * Scope pour récupérer uniquement les posts publiés
        * Usage : Post::publie()->get()
        *
        * @param \Illuminate\Database\Eloquent\Builder $query
        * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }

    /**
        * Scope pour récupérer uniquement les brouillons
        * Usage : Post::brouillon()->get()
        *
        * @param \Illuminate\Database\Eloquent\Builder $query
        * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeBrouillon($query)
     {
        return $query->where('statut', 'brouillon');
    }
}
