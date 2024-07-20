<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

use Laravel\Sanctum\PersonalAccessToken;


class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', auth()->user()->id)->get());
    }

    public function updateName(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $path = '';
            if ($request->hasFile('avatar')) {
      $uploadedFiles = $request->file('avatar');
        $uploadFolder = 'assets/img';

 $path = $file->store($uploadFolder);
        // Loop through each file and store it'
        
      
     
            // Return a response or handle the rest of your logic
}
    
        
        $user->firstName = $request->firstName;
            $user->surName = $request->surName;
            $user->email = $request->email;
            $user->avatar = $path;
            $user->phone = $request->phone;
            $user->save();
      
        return response()->json([
            'message' => translate('Profile information has been updated successfully')
        ]);
    }

    public function getUserInfoByAccessToken(Request $request)
    {

        $false_response = [
            'result' => false,
            'id' => 0,
            'name' => "",
            'email' => "",
            'avatar' => "",
            'avatar_original' => "",
            'phone' => ""
        ];



        $token = PersonalAccessToken::findToken($request->access_token);
        if (!$token) {
            return response()->json($false_response);
        }

        $user = $token->tokenable;



        if ($user == null) {
            return response()->json($false_response);
        }

        return response()->json([
            'result' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'avatar_original' => uploaded_asset($user->avatar_original),
            'phone' => $user->phone
        ]);
    }
    
    
    public function userlist()
    {
       return new UserCollection(User::has('products')->with('products')->paginate(10));

    }
}
