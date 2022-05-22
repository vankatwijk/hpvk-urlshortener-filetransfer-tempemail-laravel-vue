<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $fillable = ['link_id', 'created_at','countryName','countryCode','regionCode','latitude','longitude','timezone'];

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
