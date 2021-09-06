<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OrderInput ;
use App\DetailOrder;
use App\Bundling;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderInputController extends Controller
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
        $OrderInput = OrderInput::where('email', $email)->first();
        return $customer;
    }

    public function GetDataOrderInput(){

      $OrderInput = OrderInput::all();

      $response = [];
      if($OrderInput){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $OrderInput,
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



    public function find_order_input($id){
      $OrderInput = OrderInput::with(['detailorder'])->find($id);
      
      $response = [];
      if($OrderInput){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $OrderInput,
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

    public function find_detail_order($id){
        $DetailOrder = DetailOrder::find($id);
        
        $response = [];
        if($OrderInput){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $OrderInput,
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

    public function add_order_input(Request $request){

      if($request->isMethod('GET')){
        return view('admin.orderinputAdd');
      }else{
        $parameter = $request->all();
        $owner           =auth()->user()->id_owner;


         $OrderInput = new OrderInput();
         $OrderInput->code           = OrderInput::generateCode($owner,'INV');
         $OrderInput->sumber_sales   = strtolower($parameter['sumber_sales']);
         $OrderInput->no_tlp         = strtolower($parameter['no_tlp']);
         $OrderInput->nama           = strtolower($parameter['nama']);
         $OrderInput->prov           = strtolower($parameter['prov']);
         $OrderInput->kab            = strtolower($parameter['kab']);
         $OrderInput->kec            = strtolower($parameter['kec']);
         $OrderInput->kode_pos       = strtolower($parameter['kode_pos']);
         $OrderInput->addr           = strtolower($parameter['addr']);
         $OrderInput->pembayaran     = strtolower($parameter['pembayaran']);
         $OrderInput->ket_pembayaran = strtolower($parameter['ket_pembayaran']);
         $OrderInput->ekspedisi      = strtolower($parameter['ekspedisi']);
         $OrderInput->sub_total      = strtolower($parameter['sub_total']);
         $OrderInput->ongkir         = strtolower($parameter['ongkir']);
         $OrderInput->grand_total    = strtolower($parameter['grand_total']);
         $OrderInput->id_owner       = $parameter['id_owner'];
         $OrderInput->id_user       = $parameter['id_user'];



         $OrderInput->save();
         $count = sizeof($parameter['namabrg']);
         for ($i=0; $i < $count ; $i++) {

          $detail=new DetailOrder();
          $detail->id_order = $OrderInput->id;

          $detail->code = $parameter['code'][$i];
          $detail->nama = $parameter['namabrg'][$i];
          $detail->harga = $parameter['harga'][$i];
          $detail->qty = $parameter['qty'][$i];
          $detail->diskon = $parameter['diskon'][$i];
          $detail->total_price = $parameter['total'][$i];
          $detail->save();


          $codeb=$parameter['code'][$i];
         
         $bundling = Bundling::where('code',$codeb)->first();
         if (isset($bundling)) {
          $bundling                     = Bundling::where('code', $codeb)->first();
          $bundling->stock_bundling     = $bundling->stock_bundling - $parameter['qty'][$i];
          $bundling->update();
            if ($bundling->stock_bundling == 0) {
               $bundling->flag =0;
               $bundling->update();
            }
          }

         }
         

         $response = [];
         if($OrderInput){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $OrderInput,
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
    public function edit_order_input(Request $request){

      if($request->isMethod('GET')){
        return view('admin.orderinputEdit');
      }else{


        $parameter = $request->all();

        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }

         $id = $parameter['id'];
         $OrderInput = OrderInput::find($id);
        
         $OrderInput->sumber_sales   = strtolower($parameter['sumber_sales']);
         $OrderInput->no_tlp         = strtolower($parameter['no_tlp']);
         $OrderInput->nama           = strtolower($parameter['nama']);
         $OrderInput->prov           = strtolower($parameter['prov']);
         $OrderInput->kab            = strtolower($parameter['kab']);
         $OrderInput->kec            = strtolower($parameter['kec']);
         $OrderInput->kode_pos       = strtolower($parameter['kode_pos']);
         $OrderInput->addr           = strtolower($parameter['addr']);
         $OrderInput->pembayaran     = strtolower($parameter['pembayaran']);
         $OrderInput->ket_pembayaran = strtolower($parameter['ket_pembayaran']);
         $OrderInput->ekspedisi      = strtolower($parameter['ekspedisi']);
         $OrderInput->sub_total      = strtolower($parameter['sub_total']);
         $OrderInput->ongkir         = strtolower($parameter['ongkir']);
         $OrderInput->grand_total    = strtolower($parameter['grand_total']);

         $OrderInput->save();
         $delete=DetailOrder::where('id_order',$id)->delete();

         for ($i=0; $i < sizeof($parameter['code']); $i++) {

          $detail=new DetailOrder();
          $detail->id_order = $OrderInput->id;

          $detail->code = $parameter['code'][$i];
          $detail->nama = $parameter['namabrg'][$i];
          $detail->harga = $parameter['harga'][$i];
          $detail->qty = $parameter['qty'][$i];
          $detail->diskon = $parameter['diskon'][$i];
          $detail->total_price = $parameter['total'][$i];
          $detail->save();

         


         }

         $response = [];
         if($OrderInput){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $OrderInput,
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

    public function delete_order_input(Request $request , $id){
      $OrderInput = OrderInput::where('id' , $id)->delete();
      $DetailOrder = DetailOrder::where('id_order' , $id)->delete();

      $response = [];
      if($OrderInput){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $OrderInput,
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

      return response()->json($response);
    }

}
