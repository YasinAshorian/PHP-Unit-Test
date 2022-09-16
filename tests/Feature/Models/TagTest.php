<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use  RefreshDatabase, ModelHelperTesting;

    protected function model(): Tag
    {
        return new Tag();
    }

    /** @test  */
    public function TagRelationshipWithPost()
    {
        $count = rand(1, 10);

        $tag = Tag::factory()
            ->hasPosts($count)
            ->create();

        $this->assertCount($count, $tag->posts);
        $this->assertTrue($tag->posts->first() instanceof Post);
    }
}
