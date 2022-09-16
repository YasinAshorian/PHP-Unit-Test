<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use  RefreshDatabase, ModelHelperTesting;

    protected function model(): User
    {
        return new User();
    }

    /** @test */
    public function UserRelationshipWithPost()
    {
        $count = rand(1, 10);
        $user = User::factory()->hasPosts($count)->create();

        $this->assertCount($count, $user->posts);
        $this->assertTrue($user->posts->first() instanceof Post);
    }

    /** @test */
    public function UserRelationshipWithComment()
    {
        $count = rand(1, 10);
        $user = User::factory()->hasComments($count)->create();

        $this->assertCount($count, $user->Comments);
        $this->assertTrue($user->Comments->first() instanceof Comment);
    }
}
