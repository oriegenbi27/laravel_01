<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SumberSales;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class SumberSalesController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataSumberSales(){

      $SumberSales = SumberSales::all();


      $response = [];
          if($SumberSales){
            $response = [
                'message' => 'Berhasil Delete ',
                'data'    => $SumberSales,
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

    public function find_sumber_sales(Request $request , $id){
      $SumberSales     = SumberSales::find($id);
      $response = [];
      if($SumberSales){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $SumberSales,
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

    public function add_sumber_sales(Request $request){

      if($request->isMethod('GET')){
        return view('admin.sumbersalesAdd');
      }else{

        $parameter = $request->only('code' ,
                                    'nama' ,
                                    'keterangan',
                                    'id_owner'
                                  );

        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }

         $SumberSales              = new SumberSales();
         $SumberSales->code        = $parameter['code'];
         $SumberSales->nama        = $parameter['nama'];
         $SumberSales->keterangan  = $parameter['keterangan'];
         $SumberSales->id_owner    = $parameter['id_owner'];
         $SumberSales->save();
        
         $response = [];
         if($SumberSales){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $SumberSales,
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
    public function edit_sumber_sales(Request $request){

      if($request->isMethod('GET')){
        return view('admin.sumbersalesEdit');
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
         $SumberSales              = SumberSales::find($id);
         $SumberSales->code        = $parameter['code'];
         $SumberSales->nama        = $parameter['nama'];
         $SumberSales->keterangan  = $parameter['keterangan'];
         $SumberSales->id_owner    = $parameter['id_owner'];
         $SumberSales->save();
         
         $response = [];
         if($SumberSales){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $SumberSales,
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

    public function delete_sumber_sales(Request $request , $id){
      $SumberSales   = SumberSales::where('id' , $id)->delete();
        
      $response = [];
          if($SumberSales){
            $response = [
                'message' => 'Berhasil Delete ',
                'data'    => $SumberSales,
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
