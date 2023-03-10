<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AuthUserController extends Controller
{

    public function register(Request $request) {
        $validator = Validator::make($request->all(), ['phone' => 'required']);
        if ($validator->fails()) 
        {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::updateOrCreate([
            'phone' =>  request('phone'),
        ],[
            'name' => request('name'),
            'otpValid' => false,
            'provider' => config('constants.provider.direct'),
        ]);
        $user->roles()->attach(3);
        auth()->login($user);
        $user['token'] = $user->createToken(config('constants.provider.direct'))->accessToken;
        return $this->sendResponse($user, 'Done!');
    }

    public function login(Request $request)
    {
        return $this->phoneLogin($request->all());
    }

    private function phoneLogin($data)
    {
        try {
            $provider = config('constants.provider.direct');
            $data['phone'] = preg_replace('/^0+/', $data['phoneCode'], $data['phone']);
            $user = User::with('roles')->wherePhone($data['phone'])->first();
            if($user && $user->otpValid){
                auth()->login($user);
                $user['token'] =  $user->createToken($provider)->accessToken;
                return $this->sendResponse($user, 'User login successfully.');
            }
            return $this->sendError('User not found!', ['error' => 'Unauthorized']);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong!', ['error' => $th]);
        }
    }

    public function googleOauthLogin(Request $request){
        try {
            $data = $request->all();
            $user = User::whereEmail($data['user']['email'])->first();
            $provider = config('constants.provider.google');
            if($user) {
                auth()->login($user);
                $success['token']   =  $user->createToken($provider)->accessToken;
                $success['name']    =  $user->name;
                $success['photo']   =  $user->photo;
                $success['email']   =  $user->email;
                $success['phone']   =  $user->phone;
                return $this->sendResponse($success, 'User login successfully.');
            }
    
            $newUser['name'] = $data['user']['name'];
            $newUser['email'] = $data['user']['email'];
            $newUser['photo'] = $data['user']['photo'];
            $newUser['provider'] = $provider;
            $user = User::create($newUser);
            $success['token']   =  $user->createToken($provider)->accessToken;
            $success['name']    =  $user->name;
            $success['photo']   =  $user->photo;
            $success['email']   =  $user->email;
            $success['phone']   =  $user->phone;
            return $this->sendResponse($success, 'User register successfully.');

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', ['error' => $th]);
        }
    }
    
    public function logout(Request $request){
        try {
            $request->user()->token()->revoke();
            return $this->sendResponse([], 'User loggout successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', ['error' => $th]);
        }
    }
}
