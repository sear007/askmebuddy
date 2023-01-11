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
        $data['image'] = '';
        if($request->hasFile('image')){
            $data['image'] = uploadImage($request->file('image'));
        }
        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->photo = $data['image'];
        $user->save();
        return $this->sendResponse($user, 'User updated successfully.');
    }
}
