<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AmeComment;
use Tests\TestCase;
use App\Models\Ame;

class AmeCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ame_comment_belongs_to_ame_relationship()
    {
        $comment = AmeComment::factory()->create();
        $this->assertInstanceOf(Ame::class, $comment->ame);
    }

    public function test_comment_ame_is_updated_when_comment_is_created()
    {
        $comment = AmeComment::factory()->create();
        $this->assertEquals($comment->updated_at, $comment->ame->updated_at);
    }
}
