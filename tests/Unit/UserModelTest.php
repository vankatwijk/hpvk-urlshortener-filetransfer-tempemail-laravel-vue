<?php

namespace Tests\Unit;

use App\Link;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_links()
    {
        $this->actingAs(factory(User::class)->create());

        $this->assertCount(0, auth()->user()->links()->get());

        $link = factory(Link::class)->create();

        auth()->user()->links()->save($link);

        $this->assertCount(1, auth()->user()->links()->get());
    }
}
