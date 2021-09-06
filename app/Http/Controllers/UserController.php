<?php

namespace App\Http\Controllers;

use Config;
use Adldap\Adldap;
use App\User;
use DateTime;
use App\Mail\UserConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Session;
use JWTAuth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('APITokenJWT', ['except' => [
            'login', 'register' ,'userVerification'           ]
        ]);
    }

    public function index(){
      
    }
}

?>
