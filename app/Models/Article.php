<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'img'
    ];

    // Istruzione al modello Article a collegarsi alla tabella pivot article_tag con relazione one-to-many
    // Many-to-Many in Tags
      public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
