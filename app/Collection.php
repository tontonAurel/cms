<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name'
    ];


    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_collection', 'collection_id', 'post_id');
    }

    public function postsForOwner($ownerId)
    {
        return $this->posts()->where('owner_id', $ownerId)->get();
    }

}
