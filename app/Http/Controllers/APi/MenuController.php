<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Menu ;
use App\Jabatan ;
use App\Level ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataMenu(Request $request , $id){
      $level      = Level::with(['jabatan' , 'menu'])->get()->toArray();
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

      return response()->json($level);
    }

    public function find_menu(Request $request , $id){
      $menu     = Menu::find($id);
      
      $response = [];
      if($menu){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $menu,
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

    public function menu_dashboard(Request $request){

      $parameter = $request->only('nama', 'email' , 'tlp' , 'hp' , 'npwp' , 'prov' , 'kab' , 'kec' , 'kel' , 'kode_pos' ,'addr' , 'images');
                                       
      $id_owner     = auth()->user()->id_owner;
      $find         = Menu::find($id_owner);

      $photo        = $request->file('images');

      $filename     = preg_replace('/\s+/', '',$parameter['nama']).time().'.'.$photo->getClientOriginalExtension();
      $storeFile    = Storage::putFileAs(
          'public/icon', $photo, $filename
      );

      if(isset($find)){
        $menu            = $find;
        $messege            = 'Berhasil Edit';
      }else{
        $menu            = new Menu();
        $menu->id_owner  = $id_owner;
        $messege            = 'Berhasil Menu';
      }

      $response = [];
      if($menu){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $menu,
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
