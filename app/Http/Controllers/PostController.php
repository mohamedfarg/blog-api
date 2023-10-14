<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::orderBy('id','DESC')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image', // Assuming 'image' is an uploaded image
        'status' => 'in:publish,draft',
        'user_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id',
        ]);
        $post = Post::create([


            'name' => $validatedData['name'],
            'body' => $validatedData['body'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
            'user_id' => $validatedData['user_id'],
            'category_id' => $validatedData['category_id'],
        ]);

        return response()->json($post);
    }

    // show a specific post by id
    public function show($id){
        if(Post::where('id',$id)->first()){
            return new PostResource(Post::findOrFail($id));
        }else{
            return response()->json(['error'=>'post not found!']);
        }
    }


    // update post using id
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image', // Assuming 'image' is an uploaded image
        'status' => 'in:publish,draft',
        'user_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id',
        ]);
        $post = Post::find($id)->update([


            'name' => $validatedData['name'],
            'body' => $validatedData['body'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
            'user_id' => $validatedData['user_id'],
            'category_id' => $validatedData['category_id'],
        ]);

        return response()->json($post);
    }

    // remove post using id
    public function destroy(Request $request){
        try{
            $post=Post::find($request->id);
            if($post){
                $post->delete();
                return response()->json(['success'=>'post removed successfully !']);
            }else{
                return response()->json(['error'=>'post not found!']);
            }
        }catch(\Illuminate\Database\QueryException $exception){

            return response()->json(['error'=>'post belongs to an article.So you cann\'t delete this post!']);
        }
    }

    // search post by keyword
    public function searchpost(Request $request){
    $Post = Post::where('name', 'LIKE', '%' . $request->name . '%')->get();
    if(count($Post) == 0) {
        return  response()->json(['message' => 'No post match found !']);
    } else {
         return response()->json($Post);
    }
        }
}
