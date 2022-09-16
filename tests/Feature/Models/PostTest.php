<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use  RefreshDatabase, ModelHelperTesting;

    protected function model(): Post
    {
        return new Post();
    }

    /** @test */
    public function PostRelationshipWithUser()
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->assertTrue(isset($post->user->id));
        $this->assertTrue($post->user instanceof User);
    }

    /** @test */
    public function PostRelationshipWithTag()
    {
        $count = rand(1, 10);
        $post = Post::factory()->hasTags($count)->create();


        $this->assertCount($count, $post->tags);
        $this->assertTrue($post->tags()->first() instanceof Tag);
    }

    /** @test */
    public function PostRelationshipWithComment()
    {
        $count = rand(1, 10);
        $post = Post::factory()->hasComments($count)->create();


        $this->assertCount($count, $post->comments);
        $this->assertTrue($post->comments()->first() instanceof Comment);
    }
}

