<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'article_id',
        'body',
        'code',
        'order',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
