<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $fillable = ['link_id', 'created_at'];

    protected $hidden = [
        'id',
        'link_id',
        'updated_at',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
