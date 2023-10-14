<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CommentsResource;
use App\Models\Comments;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comments::all();

         return CommentsResource::collection($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required',
            'user_id' => 'required',
            'post_id' => 'required',
        ]);

        $comment = Comments::create($validatedData);

        return new CommentsResource($comment);
    }


    /**
     * Display the specified resource.
     */

public function show($id)
{
    $comment = Comments::find($id);

    if (!$comment) {
        return response()->json(['message' => 'Comment not found'], 404);
    }

    return new CommentsResource($comment);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $comment = Comments::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $validatedData = $request->validate([
            'body' => 'required',
            'user_id' => 'required',
            'post_id' => 'required',
        ]);

        $comment->update($validatedData);

        return new CommentsResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comments::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted'], 200);
    }

}
