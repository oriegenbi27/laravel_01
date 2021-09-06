<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SubJenis ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubJenisController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataSubJenis(){
      $id_owner = auth()->user()->id_owner;
      $SubJenis = SubJenis::where('id_owner' , $id_owner)->get();

      $response = [];
      if($SubJenis){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $SubJenis,
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

    public function find_sub_jenis(Request $request , $id){
      $SubJenis     = SubJenis::find($id);
      $response = [];
      if($SubJenis){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $SubJenis,
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

    public function add_sub_jenis(Request $request){

      if($request->isMethod('GET')){
        return view('admin.subjenisgAdd');
      }else{

        $parameter = $request->only('code' ,
                                    'nama' ,
                                    'keterangan',
                                    'id_owner'
                                  );

         $SubJenis              = new SubJenis();
         $SubJenis->code        = $parameter['code'];
         $SubJenis->nama        = $parameter['nama'];
         $SubJenis->keterangan  = $parameter['keterangan'];
         $SubJenis->id_owner    = $parameter['id_owner'];
         $SubJenis->save();
         
         $response = [];
         if($SubJenis){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $SubJenis,
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


    }
    public function edit_sub_jenis(Request $request){

      if($request->isMethod('GET')){
        return view('admin.subjenisEdit');
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

         $id                       = $parameter['id'];
         $SubJenis              = SubJenis::find($id);
         $SubJenis->code        = $parameter['code'];
         $SubJenis->nama        = $parameter['nama'];
         $SubJenis->keterangan  = $parameter['keterangan'];
         $SubJenis->id_owner    = $parameter['id_owner'];
         $SubJenis->save();
         
         $response = [];
         if($SubJenis){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $SubJenis,
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

    public function delete_sub_jenis(Request $request , $id){
      $SubJenis      = SubJenis::where('id' , $id)->delete();
      
      $response = [];
      if($SubJenis){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $SubJenis,
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
