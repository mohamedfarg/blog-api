<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Categories;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Categories::orderBy('id','DESC')->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        $cat = Categories::create([

            'name' => $validatedData['name']
        ]);

        return response()->json($cat);
    }

    // show a specific category by id
    public function show($id){
        if(Categories::where('id',$id)->first()){
            return new CategoryResource(Categories::findOrFail($id));
        }else{
            return response()->json(['error'=>'Category not found!']);
        }
    }


    // update category using id
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        $cat = Categories::find($id)->update([

            'name' => $validatedData['name']
        ]);

        return response()->json("sasa");
    }

    // remove category using id
    public function destroy(Request $request){
        try{
            $category=Categories::find($request->id);
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
    $categories = Categories::where('name', 'LIKE', '%' . $request->name . '%')->get();
    if(count($categories) == 0) {
        return  response()->json(['message' => 'No category match found !']);
    } else {
         return response()->json($categories);
    }
        }
    }
