<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Satuan ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SatuanController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataSatuan(){

      $satuan = Satuan::all();

      if($satuan){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $satuan,
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

    public function find_satuan(Request $request , $id){
      $satuan     = Satuan::find($id);
     
      if($satuan){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $satuan,
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

    public function add_satuan(Request $request){

      if($request->isMethod('GET')){
        return view('admin.satuanAdd');
      }else{

        $parameter = $request->only('code' ,  
                                    'nama' , 
                                    'keterangan',
                                    'id_owner'
                                  );
        
        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }
         
         $satuan              = new Satuan();
         $satuan->code        = strtolower($parameter['code']);
         $satuan->nama        = strtolower($parameter['nama']);
         $satuan->keterangan  = strtolower($parameter['keterangan']);
         $satuan->id_owner    = $parameter['id_owner'];
         $satuan->save();
         
         if($satuan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $satuan,
              'code' => '000',
              'tipe' => 'sukses',
            ];
        }else{
          $response = [
            'message' => 'Gagal ',
            'code' => '001',
            'tipe' => 'gagal',
          ];
        };

         return response()->json($response,200);
      }


    }
    public function edit_satuan(Request $request){
     
      if($request->isMethod('GET')){
        return view('admin.satuanEdit');
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
         $satuan              = Satuan::find($id);
         $satuan->code        = strtolower($parameter['code']);
         $satuan->nama        = strtolower($parameter['nama']);
         $satuan->keterangan  = strtolower($parameter['keterangan']);
         $satuan->id_owner    = $parameter['id_owner'];
         $satuan->save();
         
         
         if($satuan){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $satuan,
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
    
    public function delete_satuan(Request $request , $id){
      $satuan     = Satuan::where('id' , $id)->delete(); 
        
      if($satuan){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $satuan,
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
