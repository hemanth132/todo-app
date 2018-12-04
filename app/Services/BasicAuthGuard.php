<?php
// app/Services/Auth/JsonGuard.php
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
 
  /**
   * Create a new authentication guard.
   *
   * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  public function __construct(UserProvider $provider, Request $request)
  {
    $this->request = $request;
    $this->provider = $provider;
    $this->user = NULL;
    $this->fetchedFromDb = false;
  }
 
  /**
   * Determine if the current user is authenticated.
   *
   * @return bool
   */
  public function check()
  {
    return ! is_null($this->user());
  }
 
  /**
   * Determine if the current user is a guest.
   *
   * @return bool
   */
  public function guest()
  {
    return ! $this->check();
  }
 
  /**
   * Get the currently authenticated user.
   *
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function user()
  {
    if (! is_null($this->user)) {
      return $this->user;
    }
    else if(!$this->fetchedFromDb){
      $this->validate();
    }
  }
     
  /**
   * Get the ID for the currently authenticated user.
   *
   * @return string|null
  */
  public function id()
  {
    if ($user = $this->user()) {
      return $this->user()->getAuthIdentifier();
    }
  }
 
  /**
   * Validate a user's credentials.
   *
   * @return bool
   */
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
       
    if (! is_null($user) && $this->provider->validateCredentials($user, $credentials)) {
      $this->setUser($user);
 
      return true;
    } else {
      return false;
    }
  }
 
  /**
   * Set the current user.
   *
   * @param  Array $user User info
   * @return void
   */
  public function setUser(Authenticatable $user)
  {
    $this->user = $user;
    return $this;
  }
}