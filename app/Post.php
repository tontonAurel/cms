<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Post extends Model implements HasMedia, HasMediaConversions
{
    use HasMediaTrait;

    protected $fillable = [
        'title', 'description', 'template_id', 'date'
    ];

    protected $dates = [
        'date'
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'post_collection', 'owner_id', 'collection_id');
    }

    public function getMediasAttribute()
    {
        return $this->collections->first()->postsForOwner($this->id);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(400);

        $this->addMediaConversion('big')
            ->width(1200);
    }

}
