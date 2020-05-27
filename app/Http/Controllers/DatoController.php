<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;

class DatoController extends Controller{

public function testDatabase()
	{
	    $user = factory(User::class)->make();

	    // Use model in tests...
	}

}