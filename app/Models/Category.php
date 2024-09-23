<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public  function subcategories(): HasMany {
        return $this->hasMany(Subcategory::class);
    }

    public function subsubcategories(): HasManyThrough
    {
        return $this->hasManyThrough(Subsubcategory::class, Category::class);
    }
}
