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
    $owner           =auth()->user()->id_owner;
    $inv       =$parameter['inv'];
    $chanel    =$parameter['chanel'];
    $order=OrderInput::where([ ['id_owner',$owner],['code',$inv] ])->update(['pembayaran'=>$chanel]);

  }

  public function Carting(Request $request){
    if($request->isMethod('GET')){

        $owner           =auth()->user()->id_owner;
        $order=OrderInput::with(['detailorder'])->where([ ['pembayaran','temp_kasir'],['log','3001001'],['id_owner',$owner],['payment','unpaid'] ])->first();
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

            // $stok=new StockController($produks->code,$data[1]);
            // $stok->kurangstock();


        }else{
            $produks    =Produk::where('code', $data[0])->first();
            if($produks->diskon >=100){
                $totalprice=($produks->harga*$data[1])-$produks->diskon;
            }else{
                $totalprice=($produks->harga-($produks->harga*$produks->diskon/100))*$data[1];
                
            }

            $order           = new OrderInput();
            $order->code     =OrderInput::generateCode($owner,'KSR');
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
        


        $response   = [
        'message' => 'success',
        'inv'  => $order->code
        ];
        return response()->json($response);
        /*****End Carting*****/
    }  
    

  }

  public function penjualan(Request $request){

    $id_owner = auth()->user()->id_owner;
    $parameter = $request->all();

    if($request->isMethod('GET')){

        $serching='';
        $sort=$parameter['dir'];
        $data=[];
    
        if (!empty($parameter['serch'])) {
            $serching=$parameter['serch'];
            $data=OrderInput::where(function($query) use ($serching){
                        $query->where('code', 'LIKE', '%'.$serching.'%')
                              ->orWhere('nama', 'LIKE', '%'.$serching.'%');
                    })
                    ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
        }else{
            
            if(!empty($parameter['rank'])){
                $ranks=base64_decode($parameter['rank']);
                $ranks=explode(":",$ranks);
    
                $data=OrderInput::where([['id_owner',$id_owner],['log','3001001']])
                    ->whereBetween('created_at',$ranks)
                    ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
            }else{
    
                $data=OrderInput::where([ ['id_owner',$id_owner],['log','3001001']])
                ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
    
            }
        }
    $array=array('data'=>$data,'count'=>OrderInput::where([ ['id_owner',$id_owner],['log','3001001']])->count());            
    return response()->json($array);
    
    }else{

        $id=$parameter['id'];

        foreach($parameter['refaund'] as $dl){
            $detail=DetailOrder::where([ ['id_order',$id],['id',$dl] ] )->update(['refaund'=>1,'ket'=>'barang dibalikin']);
        }

        $response   = [
            'code' => '000',
            'tipe' => 'success',
            'message' => 'Refound sudah diproses..',
            ];

        return response()->json($response,200);

    }

   
    

  }

  public function cartingid(Request $request,$id){
    $order=OrderInput::with(['detailorder','owner'])->find($id);
    $response = [
        'message' => 'success',
        'data' => $order
      ];
      return response()->json($response);
  }

  public function groupbytime($rank=null){
    $totalgroup=[];  
    $ordergroup = OrderInput::orderBy('created_at')->get()->groupBy(function($item) {
       $hour= date('H', strtotime($item->created_at));
        return $hour;
    });

    foreach($ordergroup as $key => $post){
        $totalgroup[] =['jam'=>$key,'count'=>$post->count(),'amount'=>$post->sum('grand_total')];
    }

    $totalgroup = collect($totalgroup)->sortByDesc('jam')->reverse()->toArray();

    
    return $totalgroup;
  }
    
  function laporan(Request $request){
     $s=explode(":",base64_decode($request->get('filter')));

    $response = [
        'message' => 'success',
        'time'=>$this->groupbytime($s[0],$s[1]),
        'harian'=>$this->chartharian($s[0],$s[1]),
        'prodak'=>$this->groupbyCode($s[0],$s[1])
      ];
      return response()->json($response);
      
  }
    
  public function chartharian($start,$end){

    $datetime1 = new \DateTime($start);
    $datetime2 = new \DateTime($end);
    $difference = $datetime1->diff($datetime2);
    $tanggal= $difference->days+1;

    for ($i=1; $i <= $tanggal; $i++) { 
        $tgl=strlen($i)==1 ?'0'.$i:$i;

        $dm=$tanggal-$i;
        $ctgl=date('Y-m-d', strtotime('-'.$dm.'days', strtotime($end)));

         $dx['day'][]=date('M-d',strtotime($ctgl));
        // $dx['order'][]=$this->OrderCount($ctgl);
        $dx['amount'][]=$this->summaryamount($ctgl);
    }
    if($tanggal <1){
        $dx=array("day"=>0,"order"=>0,"client"=>0);
    }
    return $dx;

    
    // $id_owner = auth()->user()->id_owner;  
    // $totalgroup=[];  
    // $ordergroup = OrderInput::where([['id_owner',$id_owner],
    //                 [DB::raw("(DATE_FORMAT(created_at,'%Y%m'))"),$filterdate],
    //                 ])
    //             ->orderBy('created_at')->get()->groupBy(function($item) {
    //             $hour= date('Y-m-d', strtotime($item->created_at));
    //                 return $hour;
    // });

    // foreach($ordergroup as $key => $post){
    //     $totalgroup[$key] = $post->count();
    // }

    // return $totalgroup;

  }

  function summaryamount($tgl){
    $id_owner = auth()->user()->id_owner;
      return OrderInput::where([ ['id_owner',$id_owner],['log','3001001'],[DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"),$tgl] ])->sum('grand_total');
      
  }

  public function groupbyCode($start,$end){
    $id_owner = auth()->user()->id_owner;

    $totalgroup=[];  
    $ordergroup = DetailOrder::
                    //where([ ['id_owner',$id_owner],['log','3001001'] ])
                whereBetween(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"),[$start,$end])
                ->orderBy('code')->get()->groupBy(function($item) {
        return $item->code;
    });
    $no=0;
    foreach($ordergroup as $key => $post){
        $totalgroup[]=array(
                            'code'=>$key,
                            'nama'=>$post[0]->nama,
                            'amount'=>$post->sum('total_price'),
                            'count'=>$post->count()
                        );
        $no++;                
    }

    return $totalgroup;
  }

}   
