<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\User;
use App\Models\Comments;


class CommentsController extends Controller
{
    public function create_comment(Request $request, $id){
        $input = $request->validate([
            'content' => 'required|string'     
        ]);

        $post = Posts::where('id', $id)->first();

        $comment = Comments::create([
            'content' => $input['content'],
            'author' => Auth::user()->login,
            'post_id'=> $post['id']
        ]);

        $response =[
            'comment' => $comment
        ];

        return response($response, 201);
    }

    public function get_comm_spec_post($id){
        return  Comments::where('post_id', $id)->get();
    }
    public function comment_search($id){
        return  Comments::where('id', $id)->get();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail(auth()->user()->id)['login'];
        $comment = Comments::find($id);
        if(!$comment || $comment['author'] != $user){
            $response =[
                'message'=>'Its comment is not yours or it does not exist'
            ];
    
            return response($response, 401);
        }else{
             $comment->update($request->all());
             return $comment;
        }

    }
    public function destroy($id)
    {
        $user = User::findOrFail(auth()->user()->id)['login'];
        $comment = Comments::find($id);
        if(!$comment || $comment['author'] != $user){
            $response =[
                'message'=>'Its comment is not yours or it does not exist'
            ];
    
            return response($response, 401);
        }else{ 
             return Comments::destroy($id);
        }
    }
}
