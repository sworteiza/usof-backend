<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\Categories;
use App\Models\User;
use App\Models\TableCatPost;


class PostsController extends Controller
{
    public function create_post(Request $request){
        $input = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string'
        ]);

        $cat = Categories::where('title', $input['category'])->first();
        
        if(!$cat){
            return response([
                'message' => 'No such category'
            ], 401);
        }

        $post = Posts::create([
            'title' => $input['title'],
            'content' => $input['content'],
            'author' => Auth::user()->login
        ]);

        $idPost = DB::table('Posts')->select("*")->get()->max("id");

        $category1 = Categories::all()->where('title', $input['category'])->first()['id'];

        TableCatPost::create([
            'post' => $idPost,
            'category' => $category1
        ]);
        $response =[
            'post' => $post
        ];

        return response($response, 201);
    }

    public function index(){
        return Posts::all();
    }

    public function post_search($title){
        return  Posts::where('title', $title)->get();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail(auth()->user()->id)['login'];
        $post = Posts::find($id);
        if(!$post || $post['author'] != $user){
            $response =[
                'message'=>'Its post is not yours or it does not exist'
            ];
    
            return response($response, 401);
        }else{
             $post->update($request->all());
             return $post;
        }

    }

    public function destroy($id)
    {
        $user = User::findOrFail(auth()->user()->id)['login'];
        $post = Posts::find($id);
        if(!$post || $post['author'] != $user){
            $response =[
                'message'=>'Its post is not yours or it does not exist'
            ];
    
            return response($response, 401);
        }else{ 
             return Posts::destroy($id);
        }
    }

    public function get_post_cat($title){
        $id_post = Posts::all()->where('title', $title)->first()['id'];
        $table_cat = TableCatPost::all()->where('post', $id_post)->pluck('category');
        for($i = 0; $i < count($table_cat); $i++){
            $categories[] = Categories::all()->where('id', $table_cat[$i]);
        }
        return $categories;
    }
}
