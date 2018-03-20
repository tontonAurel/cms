<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCollection extends Pivot
{
    use SoftDeletes;

    public function getCreatedAtColumn()
    {
        return 'created_at';
    }


    public function getUpdatedAtColumn()
    {
        return 'updated_at';
    }

    public function getPostWithTrashedAttribute()
    {
        return Post::withTrashed()->find($this->post_id);
    }

    public function getPostAttribute()
    {
        return Post::find($this->post_id);
    }

}
