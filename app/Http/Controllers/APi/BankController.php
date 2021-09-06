<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Bank ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BankController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    private function checkUser($code)
    {
        $bank = Bank::where('code', $code)->first();
        return $bank;
    }

    public function GetDataBank(){

      $bank = Bank::all();

      $response = [];
          if($bank){
            $response = [
                'message' => 'Berhasil Delete ',
                'data'    => $bank,
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



    public function find_bank($id){
      $bank = Bank::find($id);
      $response = [];
          if($bank){
            $response = [
                'message' => 'Berhasil Find ',
                'data'    => $bank,
                'code' => '000',
                'tipe' => 'sukses',
              ];
          }else{
            $response = [
              'message' => 'Gagal Find ',
              'code' => '001',
              'tipe' => 'gagal',
            ];
          }

      return response()->json($response);
    }

    public function add_bank(Request $request){

      if($request->isMethod('GET')){
        return view('admin.add_bank');
      }else{

        $parameter = $request->only('code' ,
                                    'cabang' ,
                                    'no_rek' ,
                                    'keterangan' ,
                                    'id_owner' );


        if ($this->checkUser($parameter['code']) != null) {
          return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
         }

         $bank                  = new Bank();
         $bank->code            = strtolower($parameter['code']);
         $bank->cabang          = strtolower($parameter['cabang']);
         $bank->no_rek          = strtolower($parameter['no_rek']);
         $bank->keterangan      = $parameter['keterangan'];
         $bank->id_owner        = strtolower($parameter['id_owner']);


         $response = [];
          if($bank){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $bank,
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

    public function edit_bank(Request $request){

        if($request->isMethod('GET')){
          return view('admin.bankEdit');
        }else{


          $parameter = $request->only('id',
                                      'code' ,
                                      'cabang' ,
                                      'no_rek' ,
                                      'keterangan' ,
                                      'id_owner' );

          // if ($this->checkUser($parameter['cabang']) != null) {
          //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
          //  }

           $id = $parameter['id'];
           $bank = bank::find($id);
           $bank->code = strtolower($parameter['code']);
           $bank->cabang = strtolower($parameter['cabang']);
           $bank->no_rek = strtolower($parameter['no_rek']);
           $bank->keterangan = strtolower($parameter['keterangan']);
           $bank->id_owner = strtolower($parameter['id_owner']);


           $bank->save();

           $response = [];
          if($bank){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $bank,
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


      public function delete_bank(Request $request , $id){
        $bank     = Bank::where('id' , $id)->delete();
          
          $response = [];
          if($bank){
            $response = [
                'message' => 'Berhasil Delete ',
                'data'    => $bank,
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
