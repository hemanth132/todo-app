<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(){
    	$inputData = request()->only(['email','password']);
    	$inputData['password'] = md5($inputData['password']);
    	$response = \App\User::create($inputData);
    	return $response;
    }
}
