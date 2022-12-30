<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|sometimes|unique:users,email,'.auth()->user()->id,
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $data = $request->all();
        if($request->hasFile('photo')){
            $data['photo'] = uploadImage($request->file('photo'));
        }
        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->photo = $data['photo'];
        $user->save();
        return $this->sendResponse($user, 'User register successfully.');
    }
}
