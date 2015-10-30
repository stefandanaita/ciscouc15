<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Routing\Controller;
use View;
use Auth;

class AuthController extends Controller
{
  /**
    * Redirect the user to the Google authentication page.
    *
    * @return Response
    */
  public function redirectToProvider()
  {
    return Socialite::driver('google')->redirect();
  }

  /**
    * Obtain the user information from Google.
    *
    * @return Response
    */
  public function handleProviderCallback()
  {
    try {
      $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
      return view('welcome');
    }

    $userId     =   $user->getId();
    $userName   =   $user->getName();
    $userEmail  =   $user->getEmail();
    $userAvatar =   $user->getAvatar();
    return view('dashboard', ['userId' => $userId, 'userName' => $userName, 'userEmail' => $userEmail, 'userAvatar' => $userAvatar]);
  }
}
