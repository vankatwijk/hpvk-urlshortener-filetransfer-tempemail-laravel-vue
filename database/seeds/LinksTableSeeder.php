<?php

use App\Link;
use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Link::class, 10)->create([
            'user_id' => 1,
        ])->each(function ($link) {
            for ($i = 0; $i < 500; $i++) {
                $link->clicks()->create([
                    'created_at' => \Carbon\Carbon::now()->addWeeks(rand(1, 52))->format('Y-m-d H:i:s')
                ]);
            }
        });
    }
}
