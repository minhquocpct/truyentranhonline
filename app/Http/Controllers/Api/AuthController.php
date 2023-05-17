<?php

namespace App\Http\Controllers\Api;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
class AuthController extends Controller
{
    public function login(Request $request){
    	$creds = $request->only(['email','password']);

    	if(!$token=JWTAuth::attempt($creds)){
    		return response()->json([
    			'success'=>false,
    			'message'=>'invalid account'
    		]);
    	}
    	return response()->json([
    		'success'=>true,
    		'token'=>$token,
    		'user'=>Auth::user()
    	]);
    }

    public function signup(Request $request){
    	$user = new User;
        $email= $request->email;
        if (User::where('email', 'like',"%$email%")->count() > 0)
            {
                return response()->json([
                'success'=>false,
                'unique'=>true
            ]);
        } else{
    	try{
    		$user->name = $request->name;
        	$user->email = $request->email;
        	$user->password = bcrypt($request->password);
        	$user->quyen = 0;
        	$user->save();

        	return response()->json([
                'success'=>true,
                'message'=>'sign up success'
            ]);
    	}
    	catch(Exception $e){
    		return response()->json([
    			'success'=>false,
    			'message'=>''.$e
    		]);
    	}
        }
    }

    public function logout(Request $request){
    	try{
    		JWTAuth::invalidate(JWTAuth::parseToken($request->token));
    		return response()->json([
    			'success'=>true,
    			'message'=>'logout success'
    		]);

    	}
    	catch(Exception $e){
    		return response()->json([
    			'success'=>false,
    			'message'=>''.$e
    		]);
    	}
    }
    public function sendMail(Request $request)
    {
        $email= $request->email;
        if (User::where('email', 'like',"%$email%")->count() > 0)
        {
            $user = User::where('email', $request->email)->firstOrFail();
            $newpassword = Str::random(6);
            $user->password = bcrypt($newpassword);
            $user->save();
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => $newpassword,
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }
  
            return response()->json([
                'success'=>true,
                'message' =>'We have e-mailed your password reset link!',
        
            ]);
        }
        else
        {
            return response()->json([
                'success'=>false,
                'nonexist'=>true
            ]);
        }
        
    }
    public function edit(Request $request){

        $user = User::find($request->id);
            if($request->password!=''){
                    if(Auth::attempt(['email'=>$user->email,'password'=>$request->oldpassword])){
                        $user->password = bcrypt($request->password);
                        $user->update();
                        return response()->json([
                                'user'=>$user,
                                'success'=>true,
                                'message'=>'edit pass success'
                        ]);
                    
                    }
                    else{
                        return response()->json([
                            'success'=>false,
                            'oldpass'=>true,
                            'message'=>'old pass invalid'
                            ]);
                    }
                    
            }
            else
            {
                $user->name = $request->name;
                $user->update();
                    return response()->json([
                        'user'=>$user,
                        'success'=>true,
                        'message'=>'edit success'
                    ]);
            }
        
        
    }

}
