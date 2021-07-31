<?php

namespace App;

use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'original',
    ];

    protected $hidden = [
        'user_id',
        'updated_at',
        'clicks'
    ];

    protected $appends = [
        'short',
        'clicksByMonth',
        'totalClicks',
    ];

    public function resolveRouteBinding($value)
    {
        // Check if it's a hashid encoded short link
        if (count(app()->encoder->decode($value)) > 0) {
            $decodedId = app()->encoder->decode($value)[0];
            return $this->where('id', $decodedId)->first();
        }

        abort(404);
    }

    public function addClick($date)
    {
        $this->clicks()->create([
            'link_id' => $this->id,
            'created_at' => $date,
        ]);

        //TODO: Job queue instead, faster redirection
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    public function getClicksByMonthAttribute()
    {
        $clicksByMonth = array_fill(0, 12, 0);

        if (count($this->clicks) === 0) {
            return $clicksByMonth;
        }

        foreach ($this->clicks as $click) {
            $clicksByMonth[$click->month - 1] = $click->click_count;
        }

        return $clicksByMonth;
    }

    public function getTotalClicksAttribute()
    {
        return array_reduce($this->clicksByMonth, function ($carry, $item) {
            return $carry + $item;
        });
    }

    public function getShortAttribute()
    {
        return app()->encoder->encode($this->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
