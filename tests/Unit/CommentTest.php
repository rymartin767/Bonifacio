<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use Tests\TestCase;
use App\Models\Ame;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ame_comment_belongs_to_ame_relationship()
    {
        $ame = Ame::factory()->create();
        $ame->comments()->create(Comment::factory()->raw());

        $this->assertCount(1, $ame->comments);
    }

    public function test_comment_ame_is_updated_when_comment_is_created()
    {
        $ame = Ame::factory()->create();
        $comment = $ame->comments()->create(Comment::factory()->raw());
        
        $this->assertEquals($comment->updated_at, $ame->updated_at);
    }
}
