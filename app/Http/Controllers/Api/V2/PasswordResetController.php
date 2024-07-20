<?php

namespace App\Http\Controllers\Api\V2;

use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\OTPVerificationController;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Hash;

class PasswordResetController extends Controller
{
    
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));
        $this->auth = $factory->createAuth();
    }
    
    public function forgetRequest(Request $request)
    {
       
            $user = User::where('email', $request->email)->first();
       


        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => translate('User is not found')
            ], 404);
        }

        if ($user) {
            $user->verification_code = rand(100000, 999999);
            $user->save();
           
                try {

                    $user->notify(new AppEmailVerificationNotification());
                } catch (\Exception $e) {
                }
            
        }

        return response()->json([
            'result' => true,
            'message' => translate('A code is sent')
        ], 200);
    }

    public function confirmReset(Request $request)
    {
        $user = User::where('verification_code', $request->verification_code)->first();

        if ($user != null) {
           
            $user->verification_code = null;
            $user->password = Hash::make($request->password);
            
            if($user->save()){
              
                $updatedUser = $this->auth->changeUserPassword($user->uid, $request->password);
                  if($updatedUser){
            return response()->json([
                'result' => true,
                'message' => translate('Your password is reset.Please login'),
            ], 200);
                      
                  }else{
                
                      return response()->json([
                'result' => true,
                'message' => translate('Error Resetting Password'),
            ], 200);
            }
                
            }else{
                 return response()->json([
                'result' => false,
                'message' => translate('An error occured please try again'),
            ], 200);
            }
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('No user is found'),
            ], 200);
        }
    }

    public function resendCode(Request $request)
    {

      
            $user = User::where('email', $request->email)->first();
       

        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => translate('User is not found')
            ], 404);
        }

        $user->verification_code = rand(100000, 999999);
        $user->save();

   
            $user->notify(new AppEmailVerificationNotification());
     


        return response()->json([
            'result' => true,
            'message' => translate('A code is sent again'),
        ], 200);
    }
}
