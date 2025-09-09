<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function submit(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // Create a quick instance of the comment model
        $comment = new Comment();

        // Add the comment data
        $comment->body = $request->input('body');
        $comment->user_id = Auth::id();
        $comment->product_id = $postId;

        // Save the comment
        $comment->save();

        // Flash a success message and redirect back
        return redirect()->back()->with('success', 'Comment added!');
    }
}
