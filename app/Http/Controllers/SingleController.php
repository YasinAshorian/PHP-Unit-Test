<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SingleController extends Controller
{

    public function index(Post $post)
    {
        $comments = $post->comments()->latest()->paginate(15);
        return view('single', compact('post', 'comments'));
    }

    public function comment(Request $request, Post $post)
    {
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->input('text')
        ]);

        return [
            'created' => true
        ];
    }
}
