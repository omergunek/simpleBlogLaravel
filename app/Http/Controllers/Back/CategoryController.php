<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('back.categories.index',compact('categories'));
    }
    public function create(Request $request){
        $category=new Category;
        $category->name=$request->category;
        $category->slug=Str::slug($request->category);
        $category->save();
        return redirect()->back();
    }
    public function switch(Request $request){
        $category=Category::findOrFail($request->id);
        $category->status=$request->statu=="true" ? 1 : 0;
        $category->save();
    }
    public function getData(Request $request){
        $category=Category::findOrFail($request->id);
        return response()->json($category);
    }
    public function update(Request $request){
        $category=Category::find($request->id);
        $category->name=$request->category;
        $category->slug=Str::slug($request->slug);
        $category->save();
        return redirect()->back();
    }
    public function delete(Request $request){
      $category=Category::findOrFail($request->id);
      if($category->id==1){
        return redirect()->back();
      }
      $message='';
      $count=$category->articleCount();
      if($count>0){
        Article::where('category_id',$category->id)->update(['category_id'=>1]);
        $defaultCategory=Category::find(1);
        $message='Bu kategoriye ait '.$count.' makale '.$defaultCategory->name. ' kategorisine taşındı.';
      }
      $category->delete();
      return redirect()->back();
    }
}

