<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'thumbnail', 'summary', 'author', 'description', 'status', 'label', 'seo_title', 'post_category_id',
        'seo_description', 'seo_keyword', 'seo_canonical', 'info_admin', 'slug', 'schema', 'meta_robot',
    ];

    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

   
    public function childs()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    // public function ratings()
    // {
    //     return $this->hasMany(Rating::class, 'subject');
    // }
}
