<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use  RefreshDatabase, ModelHelperTesting;

    protected function model(): Comment
    {
        return new Comment();
    }

    /** @test */
    public function CommentRelationshipWithPost()
    {
        $comment = Comment::factory()->hasCommentable(Post::factory())->create();

        $this->assertTrue(isset($comment->commentable->id));
        $this->assertTrue($comment->commentable->first() instanceof Post);
    }

    /** @test */
    public function testCommentRelationshipWithUser()
    {
        $comment = Comment::factory()->for(User::factory())->create();

        $this->assertTrue(isset($comment->user->id));
        $this->assertTrue($comment->user instanceof User);
    }

}
