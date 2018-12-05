<?php
namespace App\Services;
 
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
 
class BasicAuthGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;
    protected $fetchedFromDb;
    
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = NULL;
        $this->fetchedFromDb = false;
    }
    
    public function check()
    {
        return ! is_null($this->user());
    }
    
    public function guest()
    {
        return ! $this->check();
    }
    
    public function user()
    {
        if ($this->user !== null)
        {
            return $this->user;
        }
        else if(!$this->fetchedFromDb)
        {
            $this->validate();
        }
    }
       
    public function id()
    {
        if ($this->user() !== null)
        {
            return $this->user()->getAuthIdentifier();
        }
    }
    
    public function validate(Array $credentials=[])
    {
        $email = $this->request->header('PHP_AUTH_USER');
        $password = $this->request->header('PHP_AUTH_PW');

        if(empty($email) || empty($password))
        {
            return false;
        }
        $credentials = compact('email','password');
        $user = $this->provider->retrieveByCredentials($credentials);
        $this->fetchedFromDb = true;
           
        if (! is_null($user) && $this->provider->validateCredentials($user, $credentials))
        {
            $this->setUser($user);
            return true;
        }
        else
        {
          return false;
        }
    }
    
    public function setUser(Authenticatable $user)
    {
      $this->user = $user;
      return $this;
    }
}