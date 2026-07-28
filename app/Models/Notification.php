<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'article_id',
        'title',
        'user_name',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}