<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    // Istruzione al modello Tag a collegarsi alla tabella pivot article_tag con relazione one-to-many
    // Many-to-Many in Articles
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
