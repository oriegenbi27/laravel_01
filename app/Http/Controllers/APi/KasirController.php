<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OrderInput ;
use App\DetailOrder ;
use App\Produk ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class KasirController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    


  public function payment(Request $request){
    $parameter = $request->all();
    $owner     =auth()->user()->id_owner;
    $inv       =$parameter['inv'];
    $chanel    =$parameter['chanel'];
    $order=OrderInput::where([ ['id_owner',$owner],['code',$inv] ])->update(['pembayaran'=>$chanel]);

  }

  public function Carting(Request $request){
    if($request->isMethod('GET')){

        $owner           =auth()->user()->id_owner;
        $order=OrderInput::with(['detailorder'])->where([ ['log','3001001'],['id_owner',$owner],['payment','unpaid'] ])->first();
        return response()->json($order);

    }else{
        /**********************
         * Carting Post Data
         * *******************/
        $parameter = $request->all();
        $data       =$parameter['data'];
        $inv       =$parameter['inv'];
        $owner           =auth()->user()->id_owner;
        
        if($inv <> "false"){
            $produks    =Produk::where('code', $data[0])->first();

            if($produks->diskon >=100){
                $totalprice=($produks->harga*$data[1])-$produks->diskon;
                }else{
                    $totalprice=($produks->harga-($produks->harga*$produks->diskon/100))*$data[1];
                    
                }

            $order  =OrderInput::where('code',$inv)->first();
            $detail =DetailOrder::where([ ['id_order','=',$order->id],['code','=',$data[0] ]  ])->update(['qty'=>$data[1],'total_price'=>$totalprice] );  
           
            if(!$detail){
                $detail             =new DetailOrder();
                $detail->id_order   =$order->id;
                $detail->code       =$produks->code;
                $detail->nama       =$produks->nama;
                $detail->harga      =$produks->harga;
                $detail->diskon     =$produks->diskon;
                $detail->total_price =$totalprice;
                $detail->qty        =$data[1];
                $detail->save();
            }   
            $sumall=DetailOrder::where('id_order',$order->id)->sum('total_price');

            $order->update(['grand_total'=>$sumall]);



        }else{
            $produks    =Produk::where('code', $data[0])->first();
            if($produks->diskon >=100){
                $totalprice=($produks->harga*$data[1])-$produks->diskon;
            }else{
                $totalprice=($produks->harga-($produks->harga*$produks->diskon/100))*$data[1];
                
            }

            $order           = new OrderInput();
            $order->code     =OrderInput::generateCode($owner);
            $order->id_owner =$owner;
            $order->pembayaran ="temp_kasir";
            $order->log      ='3001001'; // kasir
            $order->grand_total =$totalprice;
            $order->save();


            
            
            $detail             =new DetailOrder();
            $detail->id_order   =$order->id;
            $detail->code       =$produks->code;
            $detail->nama       =$produks->nama;
            $detail->harga      =$produks->harga;
            $detail->diskon     =$produks->diskon;
            $detail->total_price =$totalprice;
            $detail->qty        =$data[1];
            $detail->save();

        }
        

        $response = [];
        if($order){
          $response = [
              'message' => 'Berhasil ',
              'data'  => $order->code,
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
        /*****End Carting*****/
    }  
    

  }

  public function penjualan(Request $request){

    $id_owner = auth()->user()->id_owner;
    $parameter = $request->all();
    $serching='';
    $sort=$parameter['dir'];

    if (!empty($parameter['serch'])) {
        $serching=$parameter['serch'];
        $data=OrderInput::where(function($query) use ($serching){
                    $query->where('code', 'LIKE', '%'.$serching.'%')
                          ->orWhere('nama', 'LIKE', '%'.$serching.'%');
                })
                ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
    }else{

        $data=OrderInput::where([ ['id_owner',$id_owner],['log','3001001']])
        ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
    }
    
    $array=array('data'=>$data,'count'=>OrderInput::where([ ['id_owner',$id_owner],['log','3001001']])->count());            
    return response()->json($array);

  }
    
    
}   
