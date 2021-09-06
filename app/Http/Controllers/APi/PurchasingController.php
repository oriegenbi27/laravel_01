<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Purchasing;
use App\DetailPurchasing;
use App\OrderInput;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

use App\Mail\CetakPurchasingMail;
use App\Library\Images;
use App\Payment;

class PurchasingController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['purchasing_cetak', 'cne']]);
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

      $response = [];
      if($purchasing){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $purchasing,
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

    public function GetDataPurchasingOldest(){

        $purchasing = Purchasing::max('id');

        $response = [];
        if($purchasing){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $purchasing,
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

    public function find_purchasing($id){
        $purchasing = Purchasing::with(['detailpurchasing'])->find($id);
        if (isset($purchasing)) {
          $response = [];
          if($purchasing){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $purchasing,
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
          
        }else{
          return view('admin.Warehouse.form')->with('success', Alert::success('Berhasil', 'success'));
        }
       



      }

    public function purchasing_cetak(Request $request,$id){


        if($request->isMethod('POST')){
            $parameter = $request->all();

         $id                      = $parameter['id'];
         $purchasing              = Purchasing::find($id);
         $purchasing->tgl_kirim   = $parameter['code'];

         $purchasing->save();
         $response = [];
         if($purchasing){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $purchasing,
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

        }else{
          $purchasing = Purchasing::with(['detailpurchasing','owner'])->find($id);
          $response = [];
          if($purchasing){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $purchasing,
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

    public function add_purchasing(Request $request){

        if($request->isMethod('GET')){
            return view('admin.purchasingAdd');
          }else{

            $parameter = $request->all();
            $owner           =auth()->user()->id_owner;
           

             $purchasing              = new Purchasing();
             $purchasing->code        = Purchasing::generateCode($owner,'PO');
             $purchasing->supplier    = strtolower($parameter['supplier']);
             $purchasing->npwp        = strtolower($parameter['npwp']);
             $purchasing->email       = $parameter['email'];
             $purchasing->alamat      = strtolower($parameter['alamat']);
             $purchasing->category    = strtolower($parameter['category']);
             $purchasing->grand_total = $parameter['totalbayar'];
             $purchasing->status      = "pending";
             $purchasing->id_owner    = $parameter['id_owner'];
             
             $purchasing->payment     = "unpaid";
             $purchasing->save();

             for ($i=0; $i < sizeof($parameter['nama_item']) ; $i++) {
                $detail=new DetailPurchasing();
                $detail->id_purchasing = $purchasing->code;

                $detail->jenis_barang = $parameter['jenis'][$i];
                $detail->nama        = $parameter['nama_item'][$i];
                $detail->harga       = $parameter['harga'][$i];
                $detail->qty         = $parameter['qty'][$i];
                $detail->actual      = 0;
                $detail->diskon      = $parameter['diskon'][$i];
                $detail->total_harga = $parameter['totbarang'][$i];
                $detail->satuan      = $parameter['satuan'][$i];
                $detail->save();


             }



             $response = [];
             if($purchasing){
               $response = [
                   'message' => 'Berhasil ',
                   'data'    => $purchasing,
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

             if (env('APP_ENV') == 'production') {
                Mail::to($purchasing->email)->send(new CetakPurchasingMail($purchasing, route('Purchasing Cetak', $purchasing->id)));
               }

             return response()->json($response,200);
          }


    }



    public function edit_purchasing(Request $request){
      $decode = base64_decode($request->get('code'));
      $id_brand = explode('::' , $decode);
      $id   = $id_brand[0];

      if($request->isMethod('GET')){
        return view('admin.purchasingEdit');
      }else{


        $parameter = $request->all();


         $id = $parameter['id'];
         $id_owner = auth()->user()->id_owner;

         $purchasing              = Purchasing::find($id);
         $purchasing->supplier    = strtolower($parameter['supplier']);
         $purchasing->email       = $parameter['email'];
         $purchasing->npwp        = strtolower($parameter['npwp']);
         $purchasing->alamat      = strtolower($parameter['alamat']);
         $purchasing->category    = strtolower($parameter['category']);
         $purchasing->id_owner    = $parameter['id_owner'];

         $purchasing->save();

         $delete=DetailPurchasing::where('id_purchasing',$id)->delete();

         for ($i=0; $i < sizeof($parameter['nama_item']) ; $i++) {
            $detail=new DetailPurchasing();
            $detail->id_purchasing = $purchasing->id;

            $detail->nama   = $parameter['nama_item'][$i];
            $detail->harga       = $parameter['harga'][$i];
            $detail->qty         = $parameter['qty'][$i];
            $detail->diskon      = $parameter['diskon'][$i];
            $detail->satuan      = $parameter['satuan'][$i];
            $detail->save();


         }


         $response = [];
         if($purchasing){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $purchasing,
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


    public function edit_tglkirim(Request $request){

        if($request->isMethod('GET')){
          return view('admin.purchasingEdit');
        }else{


          $parameter = $request->all();


           $id = $parameter['id'];
           $id_owner = auth()->user()->id_owner;

           $purchasing              = Purchasing::find($id);
           $purchasing->status      = "process";
           $purchasing->tgl_kirim   = $parameter['tgl_kirim'];
           $purchasing->id_owner    = $parameter['id_owner'];


           $purchasing->save();



           $response = [];
           if($purchasing){
             $response = [
                 'message' => 'Berhasil ',
                 'data'    => $purchasing,
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

    // Bayar
    public function bayar_purchasing(Request $request){
      

      if($request->isMethod('GET')){
        return view('admin.bayar');
      }else{


        $parameter = $request->all();
        $id_owner       = auth()->user()->id_owner;

        $data['nama'] = $parameter['ponomor'];
        $data['file'] = $request->file('images');
        $data['path'] = 'public/produk';
        $data['images'] = $parameter['tglbayar'];

        $move = new Images();
        $action = $move->MovePath($data);

         
         $purchasing              = Purchasing::find($parameter['ponomor']);
         $purchasing->tgl_bayar   = $parameter['tglbayar'];
         $purchasing->ket_bayar   = $parameter['ket'];
         $purchasing->image   = $action;
         $purchasing->payment = "paid";
         $purchasing->save();
         $data_purchasing = json_encode($purchasing);

         $payment               = new Payment();
         $payment->id_order     = $parameter['ponomor'];
         $payment->number       = Payment::generateCode();
         $payment->amount       = $parameter['totalbayar'];
         $payment->method       ="Purchasing";
         $payment->payloads     = $data_purchasing;
         $payment->payment_type = "bank_transfer";
         $payment->vendor_name  = $parameter['bank'];
         $payment->save();

         $response = [];
         if($purchasing){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $purchasing,
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


    public function detail_purchasing(Request $request){
      $decode = base64_decode($request->get('code'));
      $id_brand = explode('::' , $decode);
      $id   = $id_brand[0];

      if($request->isMethod('GET')){
        return view('admin.purchasingEdit');
      }else{


        $parameter = $request->all();


         $id = $parameter['id'];
         $id_owner = auth()->user()->id_owner;

         $purchasing              = Purchasing::find($id);
         $purchasing->supplier    = strtolower($parameter['supplier']);
         $purchasing->email       = $parameter['email'];
         $purchasing->npwp        = strtolower($parameter['npwp']);
         $purchasing->alamat      = strtolower($parameter['alamat']);
         $purchasing->category    = strtolower($parameter['category']);
         $purchasing->id_owner    = $parameter['id_owner'];

         $purchasing->save();

         $delete=DetailPurchasing::where('id_purchasing',$id)->delete();

         for ($i=0; $i < sizeof($parameter['nama_item']) ; $i++) {
            $detail=new DetailPurchasing();
            $detail->id_purchasing = $purchasing->id;

            $detail->nama   = $parameter['nama_item'][$i];
            $detail->harga       = $parameter['harga'][$i];
            $detail->qty         = $parameter['qty'][$i];
            $detail->diskon      = $parameter['diskon'][$i];
            $detail->satuan      = $parameter['satuan'][$i];
            $detail->save();


         }


         $response = [];
         if($purchasing){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $purchasing,
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


    public function delete_purchasing(Request $request ){
        $decode = base64_decode($request->get('id'));
        $id_brand = explode('::' , $decode);
        $id   = $id_brand[1];
        $purchasing         = Purchasing::where('id' , $id)->delete();
        $DetailPurchasing   = DetailPurchasing::where('id_purchasing' , $id)->delete();
        
        $response = [];
        if($purchasing){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $purchasing,
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
