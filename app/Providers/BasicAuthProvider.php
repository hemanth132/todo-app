<?php
namespace App\Providers;
 
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
 
class BasicAuthProvider implements UserProvider
{
  /**
   * Retrieve a user by the given credentials.
   *
   * @param  array  $credentials
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function retrieveByCredentials(array $credentials)
  {
      if (empty($credentials)) {
          return;
      }
 	
 	$user = \App\User::where([
 	    ['email' , '=', $credentials['email']]
 	])->first();
 
      return $user;
  }
  
  /**
   * Validate a user against the given credentials.
   *
   * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
   * @param  array  $credentials  Request credentials
   * @return bool
   */
  public function validateCredentials(Authenticatable $user, Array $credentials)
  {
    return ($credentials['email'] == $user->email && md5($credentials['password']) == $user->getAuthPassword());
  }
 
  public function retrieveById($identifier) {}
 
  public function retrieveByToken($identifier, $token) {}
 
  public function updateRememberToken(Authenticatable $user, $token) {}
}