<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Varian ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VarianController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataVarian(){

      $varian = Varian::all();

      $response = [];
      if($varian){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $varian,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);

    }

    public function find_varian(Request $request , $id){
      $varian     = Varian::find($id);
      
      $response = [];
      if($varian){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $varian,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);
    }

    public function add_varian(Request $request){

      if($request->isMethod('GET')){
        return view('admin.varianAdd');
      }else{

        $parameter = $request->only('code' ,  
                                    'nama' , 
                                    'keterangan',
                                    'id_owner'
                                  );
        
        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }
         
         $varian              = new Varian();
         $varian->code        = strtolower($parameter['code']);
         $varian->nama        = strtolower($parameter['nama']);
         $varian->keterangan  = strtolower($parameter['keterangan']);
         $varian->id_owner    = $parameter['id_owner'];
         $varian->save();
         
      $response = [];
      if($varian){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $varian,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

         return response()->json($response,200);
      }


    }
    public function edit_varian(Request $request){
     
      if($request->isMethod('GET')){
        return view('admin.varianEdit');
      }else{


        $parameter = $request->only('id',
                                    'code' ,  
                                    'nama' , 
                                    'keterangan',
                                    'id_owner'
                                  );
        
        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }

         $id                  = $parameter['id'];         
         $varian              = Varian::find($id);
         $varian->code        = strtolower($parameter['code']);
         $varian->nama        = strtolower($parameter['nama']);
         $varian->keterangan  = strtolower($parameter['keterangan']);
         $varian->id_owner    = $parameter['id_owner'];
         $varian->save();
         
      $response = [];
      if($varian){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $varian,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
         
         return response()->json($response);
      }


    }
    
    public function delete_varian(Request $request , $id){
      $varian     = Varian::where('id' , $id)->delete(); 
        
      $response = [];
      if($varian){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $varian,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
 
      return response()->json($response);
    }

   
    
}   
