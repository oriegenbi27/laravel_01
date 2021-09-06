<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Purchasing;
use App\Produk;
use App\DetailPurchasing;
use App\Warehouse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\CetakPurchasingMail;

class WarehouseController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    private function checkUser($email)
    {
        $id_owner = auth()->user()->id_owner;
        $purchasing = Purchasing::where('id_owner' , $id_owner)
                                ->first();

        return $purchasing;
    }

    public function GetDataPurchasing(){
      $id_owner = auth()->user()->id_owner;
      $purchasing = Purchasing::where('id_owner' , $id_owner)->get();

      $response = [
        'message' => 'success get data supplier',
        'data' => $purchasing
      ];
      return response()->json($response);

    }

    public function GetDataPurchasingOldest(){

        $purchasing = Purchasing::max('id');


        $response = [];
        if($purchasing){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $purchasing,
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

    public function find_ponomor(Request $request , $id){
        $did = base64_decode($id);
        $purchasing = Purchasing::where('code' , $did)
        ->with(['detailpurchasing'])
        ->first();
        
       

        $response = [];
        if($purchasing){
          $response = [
              'message' => 'Berhasil Find Purchasing ',
              'data'    => $purchasing,
              'code' => '000',
              'tipe' => 'sukses',
            ];
        }else{
          $response = [
            'message' => 'Gagal Find Purchasing ',
            'code' => '001',
            'tipe' => 'gagal',
          ];
        }
        return response()->json($response);
      }

    public function add_warehouse(Request $request){

            $parameter = $request->all();


            $warehouse=new Warehouse();
            $warehouse->id_owner        = $parameter['id_owner'];
            $warehouse->id_purchasing   = $parameter['ponomor2'];
            $warehouse->akun            = $parameter['akun'];
            $warehouse->tipe            = $parameter['tipe'];
            $warehouse->tgl_terima      = $parameter['date'];
            $warehouse->save();



             for ($i=0; $i < sizeof($parameter['actual']) ; $i++) {


                $id                         = $parameter['id_detail'][$i];
                $detail                     = DetailPurchasing::find($id);
                $detail->actual             = $parameter['actual'][$i];
                $detail->save();

                $nama                       = $parameter["nama_item"][$i];
                $produk                     = Produk::where('nama', $nama)->first();
                $produk->stock              = $produk->stock + $parameter['actual'][$i];
                $produk->update();
                
                
                $id_purchasing            = $parameter['ponomor2'];
                $purchasing               = Purchasing::find($id_purchasing);
                if ($parameter['qty'][$i] == $parameter['actual'][$i]){
                $purchasing->status       = "completed";
                }else{
                $purchasing->status       ="split process";
                }
                $purchasing->save();
                

             }
             $response = [];
             if($detail){
               $response = [
                   'message' => 'Berhasil Delete ',
                   'data'    => $detail,
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

             return response()->json($response,200);



    }




    public function delete_purchasing(Request $request , $id){
        $purchasing         = Purchasing::where('id' , $id)->delete();
        $DetailPurchasing   = DetailPurchasing::where('id_purchasing' , $id)->delete();
        $response = [];
        if($purchasing){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $purchasing,
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
