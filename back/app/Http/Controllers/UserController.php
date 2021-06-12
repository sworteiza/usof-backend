<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->tokens()->delete();
        return User::destroy($id);
    }

    public function search($login)
    {
        return  User::where('login', $login)->get();
    }
    public function searchPic($login)
    {
        $str = User::all()->where('login', $login)->first()['prof_pic'];
        return file_get_contents(public_path($str));
    }

    public function updateProfile(Request $request)
    {
        // Form validation
        $request->validate([
            'prof_pic'     =>  'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Get current user
        $user = User::findOrFail(auth()->user()->id);
        // Set user name
        //$user->name = $request->input('name');

        // Check if a profile image has been uploaded
        if ($request->has('prof_pic')) {
            // Get image file
            $image = $request->file('prof_pic');
            // Make a image name based on user name and current timestamp
            $name = time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->prof_pic = $filePath;
        }
        // Persist user record to database
        $user->save();

        // Return user back and show a flash message
        return [
            'message' => 'Profile updated successfully.',
        ];
    }
}
