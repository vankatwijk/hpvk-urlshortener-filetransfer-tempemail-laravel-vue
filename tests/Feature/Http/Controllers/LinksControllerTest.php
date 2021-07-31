<?php


namespace Tests\Feature\Http\Controllers;


use App\Link;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_links_for_guests()
    {
        $response = $this->json('POST', '/api/shorten', [
            'original' => 'https://facebook.com'
        ]);

        $response->assertStatus(200);

        $response = $response->decodeResponseJson();

        $this->assertDatabaseHas('links', [
            'id' => $response['id'],
            'original' => $response['original'],
        ]);
    }

    public function test_it_creates_links_for_logged_in_user()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->json('POST', '/api/shorten', factory(Link::class)->raw());

        $response->assertStatus(200);

        $response = $response->decodeResponseJson();

        $this->assertDatabaseHas('links', [
            'id' => $response['id'],
            'original' => $response['original']
        ]);
    }

    public function test_it_returns_correct_json()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->json('POST', '/api/shorten', factory(Link::class)->raw());

        $link = Link::find($response->decodeResponseJson()['id']);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $link->id,
            'original' => $link->original,
            'short' => $link->short,
        ]);
    }

    public function test_it_validates_input_for_creation()
    {
        $this->actingAs(factory(User::class)->create());

        $link = factory(Link::class)->raw([
            'original' => '',
        ]);

        $this->json('POST', '/api/shorten', $link)
            ->assertJsonValidationErrors('original');

        $link = factory(Link::class)->raw([
            'original' => 'Hello there! I am not a link.',
        ]);

        $this->json('POST', '/api/shorten', $link)
            ->assertJsonValidationErrors('original');
    }

    public function test_can_view_the_link_creation_page()
    {
        $this->get('/links/create')
            ->assertStatus(200);
    }

    public function test_it_returns_all_links()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        factory(Link::class, 5)->create([
            'user_id' => auth()->id()
        ]);

        $response = $this->json('GET', '/api/links');

        $response->assertStatus(200);

        $this->assertEquals(5, sizeof($response->decodeResponseJson()));

        auth()->logout();

        $response = $this->json('GET', '/api/links');

        $response->assertStatus(200);

        $this->assertEquals(0, sizeof($response->decodeResponseJson()));
    }

    public function test_it_increments_clicks()
    {
        $this->withoutExceptionHandling();

        $link = factory(Link::class)->create();

        $this->assertEquals(0, $link->clicks()->get()->count());

        $this->get('/'.$link->short);

        $link = $link->fresh();

        $this->assertEquals(1, $link->clicks()->get()->count());
    }

    public function test_it_redirects_a_short_link()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->json('POST', '/api/shorten', factory(Link::class)->raw());

        $link = Link::find($response->decodeResponseJson()['id']);

        $this->get('/'.$link->short)
            ->assertRedirect($link->original);
    }
}