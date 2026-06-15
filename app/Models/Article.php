<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'department_id',
        'product_id',
        'priority_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class)->orderBy('order');
    }
}
