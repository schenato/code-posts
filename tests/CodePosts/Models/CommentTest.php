<?php

namespace CodePress\CodePosts\Tests\Models;

use CodePress\CodePosts\Models\Comment;
use CodePress\CodePosts\Models\Post;
use CodePress\CodePosts\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;
use Mockery as m;

/**
 * Description of CommentTest
 *
 * @author gabriel
 */
class CommentTest extends AbstractTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function test_inject_validator_in_comment_model()
    {
        $comment = new Comment();
        $validator = m::mock(Validator::class);
        $comment->setValidator($validator);

        $this->assertEquals($comment->getValidator(), $validator);
    }

    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $comment = new Comment();
        
        $comment->content = 'Conteudo do comment';

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'content' => 'Conteudo do comment'
        ]);
        $validator->shouldReceive('fails')->andReturn(false);

        $comment->setValidator($validator);

        $this->assertTrue($comment->isValid());
    }

    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $comment = new Comment();

        $comment->content = '';

        $messageBag = m::mock(Illuminate\Support\MessageBag::class);

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with(['content' => '']);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);

        $comment->setValidator($validator);

        $this->assertFalse($comment->isValid());
        $this->assertEquals($messageBag, $comment->errors);
    }

    public function test_check_if_a_comment_can_be_persisted()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment', 'post_id' => $post->id]);
        $this->assertEquals('Conteudo do comment', $comment->content);

        $comment = Comment::all()->first();
        $this->assertEquals('Conteudo do comment', $comment->content);

        $post = Comment::find(1)->post;
        $this->assertEquals('Post Test', $post->title);
    }

    public function test_can_validate_comment()
    {
        $comment = new Comment();

        $comment->content = 'Conteudo do comment';

        $factory = $this->app->make('Illuminate\Validation\Factory');
        $validator = $factory->make([], []);
                
        $comment->setValidator($validator);

        $this->assertTrue($comment->isValid());
        $comment->content = null;
        $this->assertFalse($comment->isValid());
    }
    
    public function test_can_force_delete_all_from_relationship()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        Comment::create(['content' => 'Conteudo do comment 2', 'post_id' => $post->id]);
        $post->comments()->forceDelete();
        $this->assertCount(0, $post->comments()->get());
    }
    
    public function test_can_restore_deletes_all_from_relationship()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment1 = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        $comment2 = Comment::create(['content' => 'Conteudo do comment 2', 'post_id' => $post->id]);
        $comment1->delete();
        $comment2->delete();
        $post->comments()->restore();
        $this->assertCount(2, $post->comments()->get());
    }
    
    public function test_can_soft_delete()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        $comment->delete();
        $this->assertTrue($comment->trashed());
        $this->assertCount(0, Comment::all());
    }
    
    public function test_can_get_rows_deleted()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        Comment::create(['content' => 'Conteudo do comment 2', 'post_id' => $post->id]);
        $comment->delete();
        $comments = Comment::onlyTrashed()->get();
        $this->assertEquals(1, $comments[0]->id);
        $this->assertEquals('Conteudo do comment 1', $comments[0]->content);
    }
    
    public function test_can_get_rows_deleted_and_activated()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        Comment::create(['content' => 'Conteudo do comment 2', 'post_id' => $post->id]);
        $comment->delete();
        $comments = Comment::withTrashed()->get();
        $this->assertCount(2, $comments);
        $this->assertEquals(1, $comments[0]->id);
        $this->assertEquals('Conteudo do comment 1', $comments[0]->content);
    }
    
    public function test_can_force_delete()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        $comment->forceDelete();
        $this->assertCount(0, Comment::all());
    }
    
    public function test_can_restore_rows_from_deleted()
    {
        $post = Post::create(['title' => 'Post Test', 'image' => '123456', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comment 1', 'post_id' => $post->id]);
        $comment->delete();
        $comment->restore();
        $comment = Comment::find(1);
        $this->assertEquals(1, $comment->id);
        $this->assertEquals('Conteudo do comment 1', $comment->content);
    }
}
