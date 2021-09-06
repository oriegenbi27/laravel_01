<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Library\SendToApi;
use App\Library\Images;

class PreferensiController extends Controller
{
  
  public function preferensi(Request $request){

    if($request->isMethod('GET')){
      return view('admin.Setting.preferensi');
    }else{
          $request->validate([
            'tipeakun'        => 'required',
            'nama'            => 'required'
          ],[
            '*.required'  => 'data tidak boleh kosong',
          ]);

          $data = [
            'nama'        => $request->get('nama'),
            'tipeakun'    => $request->get('tipeakun')
            
          ];

          $route  = "Preferensi ERP";
          $url    = "/api/preferensi";
          $method = "POST";
          $crud   = new SendToApi();
          $action = $crud->crud($url , $method , $data);

          dd($action);

          return Redirect::Route($route);
    }
  }

  public function preferensi_show(Request $request){

    if($request->isMethod('GET')){
      return view('admin.Setting.preferensi');
    }else{
          $request->validate([
            'tipeakun'        => 'required',
            'nama'        => 'required'
          ],[
            '*.required'  => 'data tidak boleh kosong',
          ]);

          $data = [
            'nama'        => $request->get('nama'),
            'tipe'        => $request->get('tipeakun')         
          ];
          $route  = "Preferensi ERP";
          $url    = "/api/setting/preferensi";
          $method = "POST";
          $crud   = new SendToApi();
          $action = $crud->crud($url , $method , $data);

          return Redirect::Route($route);
    }
  }

  

}
