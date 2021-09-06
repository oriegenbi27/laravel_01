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

class JabatanController extends Controller
{



  public function index(Request $request ){

    if($request->isMethod('Get')){
      $url      = '/api/GetDataJabatan';
      $method   = 'GET';
      $route    = 'Jabatan Dashboard';
      $data_send     = NULL;
      $crud     = new SendToApi();
      $jabatan    = $crud->crud($url , $method , $data_send);
    
      // dd($jabatan);
      $js = json_decode(json_encode($jabatan) , true);
      // dd($js['data']['nama']);

      $data = [];

      foreach($js as $row){
      
        $data['isi']  = array($row);
      }
      // dd($data);
      return view('admin.Jabatan.jabatan' , ['jabatan' => $jabatan]);
    }else{

        $url    = '/api/jabatan_dashboard';
        $method = 'POST';
        $route  = 'Jabatan Dashboard';
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data, $type="multipart");
        
        // return Redirect::Route($route);
    }


   }

  public function GetDataJabatan(){

    $url    = '/api/GetDataJabatan';
    $method = 'GET';
    $route  = 'Jabatan Dashboard';
    $data   = NULL;


    $crud     = new SendToApi();
    $jabatan = $crud->crud($url , $method , $data);
    dd($jabatan);
    $headers  = 'application/json';
    return response()->json($jabatan);

  }
  

  public function hak_akses(Request $request , $id){
    if($request->isMethod('Get')){
       
    }
 }

 public function AddJabatan(Request $request){
  if($request->isMethod('Get')){

  }else{
    $request->validate([
      'jabatan' => 'required',
    ],[
      '*.required' => 'data tidak boleh kosong',
    ]);
    
    $data = [
      'jabatan' => $request->get('jabatan'),
    ];

    $url    = '/api/AddJabatan';
    $method = 'POST';
    $route  = 'Setting Jabatan';
    $crud   = new SendToApi();
    $action = $crud->crud($url,$method,$data);

    return response()->json($action);
  }
 }

 public function EditJabatan(Request $request){
   $request->validate([
     'id' => 'required',
     'jabatan'=> 'required',
   ],[
    '*.required' => 'data tidak boleh kosong',
   ]);

   $data = [
     'id'      => $request->get('id'),
     'nama'    => $request->get('jabatan')
   ];
   $url     = '/api/EditJabatan';
   $method  = 'POST';
   $crud    = new SendToApi();
   $action  = $crud->crud($url,$method,$data);

   return response()->json($action);
 }

 public function DeleteJabatan(Request $request){
   $request->validate([
     'id' => 'required',
   ]);
   $id      = $request->get('id');
   $url     = '/api/DeleteJabatan/'.$id;
   $method  = 'GET';
   $crud    = new SendToApi();
   $action  = $crud->crud($url,$method,NULL);

   return response()->json($action);
 }

}
