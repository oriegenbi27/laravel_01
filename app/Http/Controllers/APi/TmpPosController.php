<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TmpPos ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TmpPosController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataDetailTmpPos(){
      $id_user  = auth()->user()->id;
      $id_owner = auth()->user()->id_owner;
      $TmpPos = TmpPos::with(['joinProduk'])
                      ->Where('id_owner' , $id_owner)
                      ->where('id_user', $id_user)
                      ->where('status' , 0)
                      ->get()->toArray();

        $response = [];
        if($TmpPos){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $TmpPos,
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

    public function find_tmp_pos(Request $request , $id){
      $id_owner = auth()->user()->id_owner;
      $TmpPos   = TmpPos::where('id', $id)
                        ->where('id_owner', $id_owner)
                        ->toArray()->get();
      
      $response = [];
      if($TmpPos){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $TmpPos,
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

    public function find_tmp_pos_produk(Request $request , $id_produk){
      $id_owner = auth()->user()->id_owner;
      $id_user  = auth()->user()->id;
      $TmpPos   = TmpPos::where('id_user', $id_user)
                        ->where('id_owner', $id_owner)
                        ->where('id_produk' , $id_produk)
                        ->get();
      $response = [];
      if($TmpPos){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $TmpPos,
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

    public function add_tmp_pos(Request $request){

      if($request->isMethod('GET')){
        $data = [
          'message' => 'Not Found',
          'status'  => '404'
        ];
        return response()->json($data);
      }else{

        $parameter = $request->only('id_produk',
                                    'qty');

         $TmpPos              = new TmpPos();
         $TmpPos->id_produk   = $parameter['id_produk'];
         $TmpPos->id_user     = auth()->user()->id;
         $TmpPos->qty         = $parameter['qty'];
         $TmpPos->id_owner    = auth()->user()->id_owner;
         $TmpPos->save();
         $response = [];
         if($TmpPos){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $TmpPos,
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
    public function edit_tmp_pos(Request $request){

      if($request->isMethod('GET')){
        return view('admin.groupcustomerEdit');
      }else{


        $parameter = $request->only('id',
                                    'qty');                                    
         $id                  = $parameter['id'];
         $TmpPos              = TmpPos::find($id);
         $TmpPos->qty         = $parameter['qty'];
         $TmpPos->save();
         $response = [];
         if($TmpPos){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $TmpPos,
               'code' => '000',
               'tipe' => 'sukses',
             ];
         }else{
           $response = [
             'message' => 'Gagal Delete ',
             'code' => '001',
             'tipe' => 'gagal',
           ];
         };

         return response()->json($response);
      }


    }

    public function delete_tmp_pos(Request $request , $id){
      $TmpPos   = TmpPos::where('id' , $id)->delete();
      $response = [];
      if($TmpPos){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $TmpPos,
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

    public function cetak_pos(Request $request){

      $parameter  = $request->only('bayar');
      $id_user    = auth()->user()->id;
      $id_owner   = auth()->user()->id_owner;

      $find_tmp   = TmpPos::where('id_user' , $id_user)
                          ->where('id_owner' , $id_owner)
                          ->where('status' , 0)
                          ->get()->toArray();
      return find_tmp;
    }



}
