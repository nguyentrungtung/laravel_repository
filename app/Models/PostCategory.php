<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title' , 'status' , 'slug' , 'seo_title' , 'seo_description','seo_keyword','seo_canonical'
    ];

    public function childs()
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }
}
