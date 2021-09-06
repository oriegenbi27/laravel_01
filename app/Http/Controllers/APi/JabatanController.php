<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jabatan ;
use App\Menu ;
use App\Level ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class JabatanController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataDetailJabatan(){
      $id_owner = auth()->user()->id_owner;
     
      $jabatan = Jabatan::with(['Level' => function ($query) {
        $query->with('Menu');
        }])->find($id_owner)->toArray();


        $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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

    public function GetDataJabatan(){
      $id_owner = auth()->user()->id_owner;
      
      $jabatan  = Jabatan::where('id_owner' , $id_owner)->get();
      
      $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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

    public function find_jabatan(Request $request , $id){
      $jabatan_id = $id; 
      $jabatan    = Level::where('jabatan_id' , $jabatan_id)->get();
      
      $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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

    public function AddJabatan(Request $request){

      $parameter  = $request->only('nama');
      
      $id_owner           = auth()->user()->id_owner;
      $jabatan            = new Jabatan();
      $jabatan->nama      = $parameter['nama'];
      $jabatan->id_owner  = $id_owner;
      $jabatan->save();
      
      $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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
    
    public function EditJabatan(Request $request){
      $parameter  = $request->only('nama' , 'id');
      $id_owner   = auth()->user()->id_owner;
      $id         = $parameter['id'];
      $jabatan    = Jabatan::find($id);
      $jabatan->nama  = $parameter['nama'];
      $jabatan->save();
     
      $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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

    public function DeleteJabatan(Request $request , $id){
      $id_owner = auth()->user()->id_owner;
      $jabatan  = Jabatan::where('id' , $id)->where('id_owner' , $id_owner)->delete();
     
      $response = [];
        if($jabatan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $jabatan,
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
