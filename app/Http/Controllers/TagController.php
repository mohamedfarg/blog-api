<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Models\Tag;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TagResource::collection(Tag::orderBy('id','DESC')->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:tags|max:255',
        ]);
        $cat = Tag::create([

            'name' => $validatedData['name']
        ]);

        return response()->json($cat);
    }

    // show a specific category by id
    public function show($id){
        if(Tag::where('id',$id)->first()){
            return new TagResource(Tag::findOrFail($id));
        }else{
            return response()->json(['error'=>'Category not found!']);
        }
    }


    // update category using id
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'name' => 'required|unique:tags|max:255',
        ]);
        $tag = Tag::find($id)->update([

            'name' => $validatedData['name']
        ]);

        return response()->json($tag);
    }

    // remove category using id
    public function destroy(Request $request){
        try{
            $category=Tag::find($request->id);
            if($category){
                $category->delete();
                return response()->json(['success'=>'Category removed successfully !']);
            }else{
                return response()->json(['error'=>'Category not found!']);
            }
        }catch(\Illuminate\Database\QueryException $exception){

            return response()->json(['error'=>'Category belongs to an article.So you cann\'t delete this category!']);
        }
    }

    // search category by keyword
    public function searchCategory(Request $request){
    $tags = Tag::where('name', 'LIKE', '%' . $request->name . '%')->get();
    if(count($tags) == 0) {
        return  response()->json(['message' => 'No category match found !']);
    } else {
         return response()->json($tags);
    }
        }
}
