<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasMedia, HasMediaConversions, Auditable
{
    use HasMediaTrait, \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $fillable = [
        'title', 'description', 'template_id', 'date'
    ];

    protected $dates = [
        'date'
    ];

    protected $appends = [
        'medias', 'thumb', 'big'
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'post_collection', 'owner_id', 'collection_id')
            ->using(PostCollection::class)
            ->withTimestamps();
    }

    public function getMediasAttribute()
    {
        if ($this->collections->isNotEmpty()) {
            return $this->collections->first()->postsForOwner($this->id);
        }
        return collect([]);
    }

    public function getThumbAttribute()
    {
        if ($this->getMedia()->isNotEmpty()) {
            return asset($this->getMedia()->first()->getUrl('thumb'));
        }
        return null;
    }

    public function getBigAttribute()
    {
        if ($this->getMedia()->isNotEmpty()) {
            return asset($this->getMedia()->first()->getUrl('big'));
        }
        return null;
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(400);

        $this->addMediaConversion('big')
            ->width(1200);
    }

}
