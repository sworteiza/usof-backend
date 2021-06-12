<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Categories;
use App\Models\Posts;
use App\Models\TableCatPost;

class CategoriesController extends Controller
{
    public function create_categorie(Request $request){
        $input = $request->validate([
            'title' => 'required|string|unique:categories,title'
        ]);

        $categorie = Categories::create([
            'title' => $input['title']
             
        ]);

        $response =[
            'categorie' => $categorie
        ];

        return response($response, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        $category->update($request->all());
        return $category;
    }

    public function destroy($id)
    {
        return Categories::destroy($id);
    }

    public function index(){
        return Categories::all();
    }

    public function cat_search($title){
        return  Categories::where('title', $title)->get();
    }

    public function get_cat_post($title){
        $id_cat = Categories::all()->where('title', $title)->first()['id'];
        $table_cat = TableCatPost::all()->where('category', $id_cat)->pluck('post');
        for($i = 0; $i < count($table_cat); $i++){
            $posts[] = Posts::all()->where('id', $table_cat[$i]);
        }
        return $posts;
    }
}
