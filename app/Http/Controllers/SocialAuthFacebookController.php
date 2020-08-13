<?php

namespace App\Http\Controllers;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use Illuminate\Http\Request;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function callback()
    {
      $getInfo = Socialite::driver('facebook')->user(); 
      echo $getInfo->birthday;
      //$user = $this->createUser($getInfo); 
     // auth()->login($user); 
     // return redirect()->to('/home');
    }
    function createUser($getInfo){
   // $user = User::where('provider_id', $getInfo->id)->first();
    
         $user = User::create([
            'name'     => $getInfo->name,
            'email'    => $getInfo->email,
        ]);
      return $user;
    }
}
