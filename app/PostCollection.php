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
}
