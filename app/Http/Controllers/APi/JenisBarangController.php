<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\JenisBarang ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JenisBarangController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataJenisBarang(){
      $id_owner = auth()->user()->id_owner;
      $JenisBarang = JenisBarang::where('id_owner' , $id_owner)->get();

      $response = [];
        if($JenisBarang){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $JenisBarang,
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

    public function find_jenis_barang(Request $request , $id){
      $jenisbarang     = JenisBarang::find($id);
      $response = [];
      if($jenisbarang){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $jenisbarang,
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

    public function add_jenis_barang(Request $request){

      if($request->isMethod('GET')){
        return view('admin.jenisbarangAdd');
      }else{

        $parameter = $request->only('code' ,
                                    'nama' ,
                                    'keterangan',
                                    'id_owner'
                                  );
         $jenisbarang              = new JenisBarang();
         $jenisbarang->code        = $parameter['code'];
         $jenisbarang->nama        = $parameter['nama'];
         $jenisbarang->keterangan  = $parameter['keterangan'];
         $jenisbarang->id_owner    = $parameter['id_owner'];
         $jenisbarang->save();
        
         $response = [];
      if($JenisBarang){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $JenisBarang,
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
    public function edit_jenis_barang(Request $request){

      if($request->isMethod('GET')){
        return view('admin.jenisbarangEdit');
      }else{


        $parameter = $request->only('id',
                                    'code' ,
                                    'nama' ,
                                    'keterangan',
                                    'id_owner'
                                  );
         $id                       = $parameter['id'];
         $jenisbarang              = JenisBarang::find($id);
         $jenisbarang->code        = $parameter['code'];
         $jenisbarang->nama        = $parameter['nama'];
         $jenisbarang->keterangan  = $parameter['keterangan'];
         $jenisbarang->id_owner    = $parameter['id_owner'];
         $jenisbarang->save();
         
         $response = [];
      if($JenisBarang){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $JenisBarang,
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

    public function delete_jenis_barang(Request $request , $id){
      $jenisbarang   = JenisBarang::where('id' , $id)->delete();
        
      $response = [];
      if($JenisBarang){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $JenisBarang,
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
