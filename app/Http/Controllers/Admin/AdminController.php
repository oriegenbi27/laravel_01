<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\UserController;
use RealRashid\SweetAlert\Facades\Alert;


use Config;
use Adldap\Adldap;
use App\User;
use DateTime;
use Exception;
use GuzzleHttp\Client;
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
use Validator;
use JWTAuth;

class AdminController extends Controller
{
    public function home(request $request)
    {
        return view('admin.home')->with('success', Alert::toast('Berhasil', 'success'));
    }

    public function flush()
    {
        Session::flush();
        return redirect()->intended('/')->with(['message' => 'Kamu berhasil keluar, silahkan masukan username dan password untuk masuk ke portal']);
    }

}    