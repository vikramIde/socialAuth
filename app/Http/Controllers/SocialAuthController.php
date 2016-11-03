<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Socialite;

use App\SocialAccountService;

class SocialAuthController extends Controller
{
    
    // redirect function
    public function redirect($service=null){
      return Socialite::driver($service)->redirect();
    }

 	// callback function
    public function callback($service=null){
      // when facebook call us a with token
      	$serviceSocial = new SocialAccountService();

      	$user = $serviceSocial->createOrGetUser(Socialite::driver($service)->user(),$service);
      	auth()->login($user);
      	return redirect()->to('/home');
    }


}
