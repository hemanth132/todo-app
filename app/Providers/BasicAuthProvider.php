<?php
namespace App\Providers;
 
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
 
class BasicAuthProvider implements UserProvider
{
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
    
    public function validateCredentials(Authenticatable $user, Array $credentials)
    {
        return (($credentials['email'] === $user->email) and 
                          (md5($credentials['password']) === $user->getAuthPassword()));
    }
    
    public function retrieveById($identifier) {}
    
    public function retrieveByToken($identifier, $token) {}
    
    public function updateRememberToken(Authenticatable $user, $token) {}
}