<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function links()
    {
        return $this->hasMany(Link::class)
            ->where('original','<>','@user')
            ->orderBy('created_at', 'DESC')
            ->with([
                'clicks' => function ($query) {
                    $query->groupBy(\DB::raw('month, link_id'))
                        ->selectRaw('MONTH(created_at) as month, count(id) as click_count, link_id');
                },
            ]);
    }

    public function treeLinks()
    {
        return $this->hasMany(Link::class)
            ->where('intree','=','1')
            ->where('original','<>','@user')
            ->orderBy('created_at', 'DESC')
            ->with([
                'clicks' => function ($query) {
                    $query->groupBy(\DB::raw('month, link_id'))
                        ->selectRaw('MONTH(created_at) as month, count(id) as click_count, link_id');
                },
            ]);
    }
}
