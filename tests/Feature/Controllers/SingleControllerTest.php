<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class SingleControllerTest extends TestCase
{
    /** @test */
    public function IndexMethod()
    {
        $post = Post::factory()->hasComments(rand(0, 5))->create();
        $response = $this->get(route('single', $post->id));

        $response->assertOk();
        $response->assertViewIs('single');
        $response->assertViewHasAll([
            'post' => $post,
            'comments' => $post->comments()->latest()->paginate(15)
        ]);
    }

    /** @test */
    public function CommentMethodWhenUserLoggedIn()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $data = Comment::factory()->state([
             'user_id' => $user->id,
             'commentable_id' => $post->id
        ])->make()->toArray();

        $response = $this->actingAs($user)
            ->withHeaders([
                'HTTP_X-Requested-with' => 'XMLHttpRequest'
            ])
            ->postJson(
           route('single.comment', $post->id),
           ['text' => $data['text']]
        );

        $response
            ->assertOk()
            ->assertJson([
                'created' => true
            ]);
        $this->assertDatabaseHas('comments', $data);
    }

    /** @test */
    public function CommentMethodWhenUserNotLoggedIn()
    {

        $post = Post::factory()->create();
        $data = Comment::factory()->state([
            'commentable_id' => $post->id
        ])->make()->toArray();

        unset($data['user_id']);

        $response = $this->withHeaders([
                'HTTP_X-Requested-with' => 'XMLHttpRequest'
            ])->postJson(
            route('single.comment', $post->id),
            ['text' => $data['text']]
        );

        $response->assertUnauthorized();
        $this->assertDatabaseMissing('comments', $data);
    }
}
