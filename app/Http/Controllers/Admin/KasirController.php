<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

// library
use App\Library\SendToApi;
use App\Library\ImagesToBase64;

use DataTables;
use Yajra\DataTables\Html\Builder;

class KasirController extends Controller
{
    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
    $this->htmlBuilder = $htmlBuilder;
    }

    public function index(){
    
    $crud   = new SendToApi();
    $url    = '/api/GetDataProduk';
    $method = 'GET';
    $route  = 'Erp Pos';
    $data   = NULL;
    $produk = $crud->crud($url , $method , $data);

    $url    = '/api/kasir/carting';
    $method = 'GET';
    $data   = NULL;
    $carting = $crud->crud($url , $method , $data);

    return view('admin.Kasir.index',['data'=>$produk,'cart'=>$carting] );
    
    }


    public function carting(Request $request){
        $data=$request->get('data');
        $inv=$request->get('inv');
        
        $url    = "/api/kasir/carting";
        $method = "POST";
        $data   =["data"=>$data,"inv"=>(empty($inv)?"false":$inv )];
        $crud   = new SendToApi();

        $action = $crud->crud($url,$method,$data);
        
        return response()->json($action);
    }

    function paymentProgress(Request $request){
        $this->initPaymentGateway();
        $data=$request->get('data');
        $inv=$request->get('inv');

        $items=[];$totalprice=0;

        foreach($data as $item){
            $items[]=array(
                'id' => $item[0],
                'name' => $item[1],
                'price' => $item[2],
                'quantity' => $item[3]
            );
            $totalprice +=$item[2];
        }

        $transaction_details = array(
            'order_id' => $inv,
            'gross_amount' => $totalprice,
          );

          $item_details = $items;

          $customer_details = array(
            'first_name'    => "Bambang",
            'last_name'     => "Hardone",
            'email'         => "Bambang@mail.com",
            'phone'         => "0484474777",
          );
  
          $credit_card['secure'] = true;

          $time = time();
          $custom_expiry = array(
              'start_time' => date("Y-m-d H:i:s O",$time),
              'unit' => 'day', 
              'duration'  => 1
          );
          
          $transaction_data = array(
              'transaction_details'=> $transaction_details,
              'item_details'       => $item_details,
              'customer_details'   => $customer_details,
              'credit_card'        => $credit_card,
              'expiry'             => $custom_expiry
          );
          $batas_bayar=date("Y-m-d h:i:s", time() + (3600 *24) );
          
        //   $_data=array(
        //         "user_id"=>$resultperson->id,
        //         "nama"=>$resultperson->fullname,
        //         "email"=>$resultperson->email,
        //         "tlp"=>$resultperson->phone_no,
        //         "tgl_register"=>date("Y-m-d H:i:s"),
        //         "orderno"=>$key['orderno'],
        //         "categori"=>$resultprodak->id_categori,
        //         "produk_id"=>$resultprodak->id,
        //         "produk"=>$resultprodak->nama,
        //         "infaq"=>$resultprodak->infaq,
        //         "infaq_sukarela"=>$infaqTambahan,
        //         "expired_bayar"=>$batas_bayar,
        //         "created"=>"B2C",
        //         "ip"=>$this->inc->get_client_ip()
        //         );	
        //     $this->dbload->SaveData(array("table"=>"paket_register","datas"=>$_data));	

        $url    = "/api/kasir/cartingpayment";
        $method = "POST";
        $data   =["chanel"=>"wallet","inv"=>$inv];
        $crud   = new SendToApi();
        $action = $crud->crud($url,$method,$data);

            
          error_log(json_encode($transaction_data));
          $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);
          error_log($snapToken);
          echo $snapToken;
    }
    
    public function penjualan(Request $request){

        if ($request->ajax()) {

            $url    = '/api/kasir/penjualan/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'].'&rank='.$request->input('s');
            $method = 'GET';
            $data   = null;
            $crud   = new SendToApi();
            $data   = $crud->crud($url,$method,$data);
            $DataTables=[];
            $countdata=0;
            foreach($data->data as $row){
                $edit=base64_encode("modif::".$row->id);
                $delete=base64_encode("trans::".$row->id);

                $DataTables[]=array(
                    "nota"=>"<span style='display:none;'>".$row->id."</span>".$row->code,
                    "nama"=>$row->nama,
                    "date"=>$row->created_at,
                    "jeniskasir"=>$row->log,
                    "status"=>'<button type="button" class="btn '.($row->payment=='paid'?'btn-success':'btn-warning').' btn-xs">'.$row->payment.'</button>',
                    "pembayaran"=>"Rp ".number_format($row->grand_total,0).'<span class="float-right label label-primary btn-xs">'.$row->pembayaran.'</span>'
                );

            $countdata =$data->count;
            }

            return response()->json([
                "draw" => intval($request->input('draw')),  
                "recordsTotal"    => $countdata, 
                "recordsFiltered" => $countdata,
                "data" => $DataTables
            ]);

        }
       $html = $this->htmlBuilder
        ->addColumn(['data' => 'nota', 'name' => 'No Nota', 'title' => 'Invoice','width'=>'20%','orderable'=>false ])
        ->addColumn(['data' => 'nama', 'name' => 'Nama', 'title' => 'Name','width'=>'20%','orderable'=>false ])
        ->addColumn(['data'=>'date'   ,'name'=>'Waktu','title'=>'Waktu','width'=>'20%','orderable'=>false ])
        ->addColumn(['data' => 'jeniskasir', 'name' => 'Jenis Kasir', 'title' => 'Level','width'=>'10%','orderable'=>false])
        ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status','width'=>'10%','orderable'=>false])
        ->addColumn(['data' => 'pembayaran', 'name' => 'Pembayaran', 'title' => 'Pembayaran','width'=>'30%','orderable'=>false])
       ->parameters([
        'responsive' => false,
        'dom' => '<"html5buttons"B> Tfgtip',
        'order' =>false,
       'buttons' => [
                    [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                    [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                    [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                    ],
                ]);
                
        return view('admin.Kasir.penjualan',compact('html'));

    }

    public function penjualandetail(Request $request){
        if($request->isMethod('GET')){
            
            $id=base64_decode($request->get('code'));
            $url    = "/api/kasir/cartingid/".$id;
            $method = "GET";
            $data   =NULL;
            $crud   = new SendToApi();
            $data = $crud->crud($url,$method,$data);
            return view('admin.Kasir.detailpenjualan',["row"=>$data]);

        }else{

            $get=$request->all();
            $id=base64_decode($request->get('code'));
            $data=[
                    'id'=>$id,
                    'refaund'=>$request->get('cek')
            ];

            $url    = "/api/kasir/penjualan";
            $method = "POST";
            $crud   = new SendToApi();
            $data = $crud->crud($url,$method,$data);
            return back()->with($data->tipe, Alert::toast($data->message, $data->tipe));

        }
       
    }


}