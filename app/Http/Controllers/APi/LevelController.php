<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Level ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class LevelController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataLevel(Request $request , $id){
      $id_owner = auth()->user()->id_owner;
      $jabatan_id = $id ;
      $level = Level::with(['jabatan'])->find($jabatan_id);

      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);
    }

    public function find_level(Request $request , $id){
      $level     = Level::find($id);
      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

      return response()->json($response);
    }

    public function level_dashboard(Request $request){
      $parameter = $request->only('jabatan_id' , 'menu_id' , 'akses_view' , 'akses_insert' , 'akses_delete' , 'akses_edit');
      $menu_id   = strtolower($parameter['menu_id']);
      $find      = Level::where('menu_id',$menu_id)->get();
     
      if(empty($find)){
        $level  = new Level();
      }else{
        $level  = $find;
      }

      $level->menu_id     = $menu_id;
      $level->jabatan_id  = $parameter['jabatan_id'];
      $level->akses_view  = strtolower($parameter['akses_view']);
      $level->akses_edit  = strtolower($parameter['akses_edit']);
      $level->akses_insert  = strtolower($parameter['akses_insert']);
      $level->akses_delete  = strtolower($parameter['akses_delete']); 
      $level->save();

      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }


      return response()->json($response);
    }

    public function add_data_batch(Request $request , $id){  
      $parameter = $request->all();
      $id_owner     = auth()->user()->id_owner;
      $id_user      = auth()->user()->id;

      $delete=Level::where([
                            ['jabatan_id','=',$parameter['jabatan'] ],
                            ['id_user','=',$id_user],
                            ['id_owner','=',$id_owner] ])->delete();
      foreach($parameter['menu']['code'] as $key){

              if(isset($parameter['menu']['view'][$key]) or isset($parameter['menu']['add'][$key]) or isset($parameter['menu']['edit'][$key]) or isset($parameter['menu']['delete'][$key]) ){

                  $level=new Level();
                  $level->jabatan_id  = $parameter['jabatan'];
                  $level->id_user    = $id_user;
                  $level->id_owner   = $id_owner;
                  $level->menu_id    = $key;

                  $level->akses_view =isset($parameter['menu']['view'][$key])?1:0;
                  $level->akses_insert = isset($parameter['menu']['add'][$key])?1:0;
                  $level->akses_edit = isset($parameter['menu']['edit'][$key])?1:0;
                  $level->akses_delete =  isset($parameter['menu']['delete'][$key])?1:0;

                  $level->save();
              }
              
            // }


      }


      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

      return response()->json($response,200);
      
    }

    public function add_data(Request $request , $id){
      
      $parameter  = $request->only('jabatan_id' ,'id_user' ,'menu_id' , 'akses_view' , 'akses_insert' , 'akses_delete' , 'akses_edit');
      $jabatan_id = $parameter['jabatan_id'];
      $menu_id    = $parameter['menu_id'];
      $find       = Level::where('menu_id',$menu_id)
                          ->where('jabatan_id' , $jabatan_id)
                          ->get();
     
      if(empty($find)){
        $level   = new Level();
      }else{
        $level  = $find;
      }

      $data = $parameter['akses_view'];

      $id_owner     = auth()->user()->id_owner;
      $id_user      = auth()->user()->id;
      $level->menu_id       = $menu_id;
      // $level->jabatan_id    = $parameter['jabatan_id'];
      // $level->akses_view    = strtolower($parameter['akses_view']);
      // $level->akses_edit    = strtolower($parameter['akses_edit']);
      // $level->akses_insert  = strtolower($parameter['akses_insert']);
      // $level->akses_delete  = strtolower($parameter['akses_delete']); 
      // $level->save();

      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }


      return response()->json($response);
                           
    }
    public function edit_add_data(Request $request , $id){
      $id_owner  = auth()->user()->id_owner;
      $parameter = $request->only('jabatan_id' , 'menu_id' , 'akses_view' , 'akses_insert' , 'akses_delete' , 'akses_edit');
      $menu_id   = strtolower($parameter['menu_id']);
      $find      = Level::where('menu_id',$menu_id)->get();

      $level  = Level::where('menu_id',$menu_id)->where('id_owner' , $id_owner)->get();
      $level->menu_id     = $menu_id;
      $level->jabatan_id  = $parameter['jabatan_id'];
      $level->akses_view  = strtolower($parameter['akses_view']);
      $level->akses_edit  = strtolower($parameter['akses_edit']);
      $level->akses_insert  = strtolower($parameter['akses_insert']);
      $level->akses_delete  = strtolower($parameter['akses_delete']); 
      $level->save();

      $response = [];
      if($level){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $level,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }


      return response()->json($response);
                           
    }
    
}   
