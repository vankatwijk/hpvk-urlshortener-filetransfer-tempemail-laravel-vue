<?php

namespace Tests\Unit;

use App\Click;
use App\Link;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClickModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_link()
    {
        $this->actingAs(factory(User::class)->create());

        $click = factory(Click::class)->create();

        $this->assertInstanceOf(Link::class, $click->link);
    }
}
