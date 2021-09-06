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

class LevelController extends Controller
{



  public function index(Request $request , $id){

    if($request->isMethod('Get')){
      $url      = '/api/find_jabatan/'.$id;
      $method   = 'GET';
      $route    = 'Level Dashboard';
      $data     = NULL;
      $crud     = new SendToApi();
      $level    = $crud->crud($url , $method , $data);

      $menu_url      = '/api/GetDataMenu/'.$id;
      $menu_method   = 'GET';
      $menu_data     = NULL;
      $menu_crud     = new SendToApi();
      $menu          = $menu_crud->crud($menu_url , $menu_method , $menu_data);

      $detail_url      = '/api/GetDataDetailJabatan';
      $detail_method   = 'GET';
      $detail_route    = 'Level Dashboard';
      $detail_data     = NULL;
      $detail_crud     = new SendToApi();
      $detail          = $detail_crud->crud($detail_url , $detail_method , $detail_data);
     
      // dd($menu); 
      return view('admin.Level.level' , ['level' => $level , 'menu' => $menu , 'detail' =>$detail]);
    }else{

      $request -> validate([
          'jabatan_id',
          'menu_id',
      ],[
        '*.required' => 'data tidak boleh kosong',
      ]);

      $result['menu_id']  = $request->get('id');
      $result['jabatan_id']  = $request->get('jabatan_id');
      $result['akses_view'] = $request->get('akses_view');
      $result['akses_insert'] = $request->get('akses_insert');
      $result['akses_edit'] = $request->get('akses_edit');
      $result['akses_delete'] = $request->get('akses_delete');
      
      $data = [] ; $where = [];
    

      foreach($result as $row){
        $data['jabatan_id']   = $result['jabatan_id'];
        $data['menu_id']      = $result['menu_id'];
        $data['akses_view']   = $result['akses_view'] ;
        $data['akses_insert'] = $result['akses_insert'];
        $data['akses_edit']   = $result['akses_edit'];
        $data['akses_delete'] = $result['akses_delete'];
       
      $url    = '/api/add_data_batch/'.$id;
      $method  = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);

        dd($action); 
      
      }
    

      
    }


   }

  public function GetDataLevel(){

    $url    = '/api/GetDataLevel';
    $method = 'GET';
    $route  = 'Level Dashboard';
    $data   = NULL;


    $crud     = new SendToApi();
    $level = $crud->crud($url , $method , $data);
    dd($level);
    $headers  = 'application/json';
    return response()->json($level);

  }

  

}
