<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::with('user:id,name','comments', 'comments.user:id,name')->where('hide', 0)->orderBy('id', 'desc');
        if ($request->search){
            $posts = $posts->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }
        $posts = $posts->paginate(10);
        return inertia('Blog', ['posts' => $posts, 'user' => auth()->user()]);
    }

    public function getMyPosts()
    {
        $posts = Post::where('user_id', auth()->id())->paginate(10);
        return inertia('Dashboard', ['posts' => $posts]);
    }

    public function deletePost($id)
    {
        $posts = Post::where('id', $id)->delete();
        return response(['success' => 'success']);
    }

    public function hidePost($id)
    {
        $post = Post::find($id);

        $post->hide = !$post->hide;

        $post->save();

        return back();
    }

    public function postComment(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:5'],
            'body' => ['required', 'min:10']
        ]);

        // if($request->id == null)
        //     $post = new Post();
        // else
        //     $post = Post::find($request->id);

        // $post->user_id = auth()->id();
        // $post->title = $request->title;
        // $post->body = $request->body;
        // $post->save();

        $post = Post::updateOrCreate([
            'id' => $request->id
        ], [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body
        ]);

        return redirect()->back()->with('success', 'Successfully posted');
    }

    public function viewPost($id)
    {
        $post = Post::with('user:id,name','allComments', 'allComments.user:id,name')->where('id', $id)->first();
        return inertia('ViewPost', ['post' => $post, 'user' => auth()->user()]);
    }
}
