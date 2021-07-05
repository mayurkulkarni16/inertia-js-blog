<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function hideComment($id)
    {
        $comment = Comment::find($id);

        $comment->hide = !$comment->hide;

        $comment->save();

        return redirect()->back();
    }

    public function postComments($id)
    {
        $post = Post::find($id);

        $comments = $post->comments()->get();

        return inertia('PostComments', ['comments' => $comments]);
    }

    public function comment(Request $request)
    {
        $comment = new Comment();
        $comment->post_id = $request->id;
        $comment->user_id = auth()->id();
        $comment->body = $request->comment;
        $comment->save();
        return response(['success' => 'Successfully posted', 'comment' => $comment]);
    }
}
