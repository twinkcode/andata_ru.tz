<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Comment model.
 */
class CommentTest extends TestCase
{
    /**
     * Test the create method of Comment model.
     */
    public function testCreateMethod()
    {
        $comment = new Comment(
            'Test name',
            'test@test.test',
            'This is a test comment title',
            'This is a test comment text.'
        );
        $comment->save();

        $this->assertEquals('Test name', $comment->name);
        $this->assertMatchesRegularExpression('/^.+\@\S+\.\S+$/', $comment->email);
        $this->assertEquals('test@test.test', $comment->email);
        $this->assertEquals('This is a test comment title', $comment->title);
        $this->assertEquals('This is a test comment text.', $comment->text);
    }

    /**
     * Test the all method of Comment model.
     */
    public function testAllMethod()
    {
        $comments = Comment::all();
        $this->assertIsArray($comments, 'assert is $comments array');
        if (sizeof($comments) > 0) {
            $comment = $comments[0];
            $this->assertArrayHasKey('id', $comment);
            $this->assertArrayHasKey('name', $comment);
            $this->assertArrayHasKey('email', $comment);
            $this->assertArrayHasKey('title', $comment);
            $this->assertArrayHasKey('text', $comment);
            $this->assertArrayHasKey('created_at', $comment);
        }
    }
}
