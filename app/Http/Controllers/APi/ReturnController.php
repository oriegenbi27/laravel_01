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

class ReturnController extends Controller
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



    public function add_return(Request $request){

            $parameter = $request->all();


            $warehouse=new Warehouse();
            $warehouse->id_owner        = $parameter['id_owner'];
            $warehouse->id_purchasing   = $parameter['ponomor2'];
            $warehouse->akun            = $parameter['akun'];
            $warehouse->tipe            = $parameter['tipe'];
            $warehouse->tgl_terima      = $parameter['date'];
            $warehouse->save();



             for ($i=0; $i < sizeof($parameter['return']) ; $i++) {
                $id                         = $parameter['id_detail'][$i];
                $detail                     = DetailPurchasing::find($id);
                $detail->return              = $parameter['return'][$i];
                $detail->save();

                // $nama                       = $parameter["nama_item"][$i];
                // $produk                     = Produk::where('nama', $nama)->first();
                // $produk->stock              = $produk->stock + $parameter['actual'][$i];
                // $produk->update();


                $id_purchasing            = $parameter['ponomor2'];
                $purchasing               = Purchasing::find($id_purchasing);
                $purchasing->status       = "return";
                $purchasing->save();





             }


             $response = [];
             if($detail){
               $response = [
                   'message' => 'Berhasil ',
                   'data'    => $detail,
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



    public function delete_purchasing(Request $request , $id){
        $purchasing         = Purchasing::where('id' , $id)->delete();
        $DetailPurchasing   = DetailPurchasing::where('id_purchasing' , $id)->delete();
        $response = [];
        if($DetailPurchasing){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $DetailPurchasing,
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
