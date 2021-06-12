<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\User;
use App\Models\Likes;


class LikesController extends Controller
{
    public function create_like_post(Request $request, $id)
    {
        $input = $request->validate([
            'type' => 'required|string',
        ]);

        $select = DB::table('Likes')
            ->select("*")
            ->where('author', '=', Auth::user()->login)
            ->where('status_id', '=', $id)->get();

        if (count($select) == 0) {
            $like = Likes::create([
                'author' => Auth::user()->login,
                'status' => 'post',
                'status_id' => $id,
                'type' => $input['type']
            ]);

            $response = [
                'like' => $like
            ];
            return response($response, 201);
        } else {
            return response([
                'message' => 'You can not make more than 1 like'
            ], 401);
        }
    }

    public function get_like_un_post($id)
    {
        return  Likes::where('status_id', $id)->get();
    }

    public function destroy_like_post($id)
    {
        $like = DB::table('Likes')
            ->select("*")
            ->where('author', '=', Auth::user()->login)
            ->where('status_id', '=', $id)->get();

        if (count($like) == 0) {
            $response = [
                'message' => 'Its like is not yours or it does not exist'
            ];

            return response($response, 401);
        } else {
            return Likes::destroy(($like->pluck('id')[0]));
        }
    }

    public function create_like_comment(Request $request, $id)
    {
        $input = $request->validate([
            'type' => 'required|string',
        ]);

        $select = DB::table('Likes')
            ->select("*")
            ->where('author', '=', Auth::user()->login)
            ->where('status_id', '=', $id)->get();

        if (count($select) == 0) {
            $like = Likes::create([
                'author' => Auth::user()->login,
                'status' => 'comment',
                'status_id' => $id,
                'type' => $input['type']
            ]);

            $response = [
                'like' => $like
            ];
            return response($response, 201);
        } else {
            return response([
                'message' => 'You can not make more than 1 like'
            ], 401);
        }
    }
    public function get_like_un_comment($id)
    {
        return  Likes::where('status_id', $id)->get();
    }

    public function destroy_like_comment($id)
    {
        $like = DB::table('Likes')
            ->select("*")
            ->where('author', '=', Auth::user()->login)
            ->where('status_id', '=', $id)->get();

        if (count($like) == 0) {
            $response = [
                'message' => 'Its like is not yours or it does not exist'
            ];

            return response($response, 401);
        } else {
            return Likes::destroy(($like->pluck('id')[0]));
        }
    }
}
