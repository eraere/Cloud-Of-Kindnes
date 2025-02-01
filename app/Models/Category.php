<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'icon'];

    public function compliments(): HasMany
    {
        return $this->hasMany(Compliment::class);
    }
} 