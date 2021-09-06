<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\OrderInput;

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
use App\Bundling;

class OrderInputController extends Controller
{


  public function index(){
    // $user = User::where('verification_token', $token)->first();


    $url    = '/api/GetDataOrderInput';
    $method = 'GET';
    $route  = 'Erp Order Input';
    $data   = NULL;


    $crud     = new SendToApi();

    $OrderInput = $crud->crud($url , $method , $data);
    
    return view('admin.OrderInput.orderinput' , ['OrderInput' => $OrderInput]);

   }

  public function GetDataOrderInput(){

    $url    = '/api/GetDataOrderInput';
    $method = 'GET';
    $route  = 'Erp Order Input';
    $data   = NULL;


    $crud     = new SendToApi();
    $OrderInput = $crud->crud($url , $method , $data);
    $headers  = 'application/json';
    return response()->json($OrderInput);
  }

  public function add_order_input(Request $request){

    if($request->isMethod('GET')){

      $url    = '/api/GetDataProduk';
      $method = 'GET';
      $data   = NULL;
      $crud     = new SendToApi();
      $produk = $crud->crud($url , $method , $data);

      $sumber_url    = '/api/GetDataSumberSales';
      $sumber_method = 'GET';
      $sumber_data   = NULL;
      $sumber_crud     = new SendToApi();
      $sumbersales = $crud->crud($sumber_url , $sumber_method , $sumber_data);

      

      return view('admin.OrderInput.orderinputAdd', ['produk' => $produk, 'sumber' => $sumbersales]);
    }else{
      $request->validate([

                'sumber_sales'      => 'required',
                'no_tlp'            => 'required',
                'nama'              => 'required',
                'prov'              => 'required',
                'kab'               => 'required',
                'kec'               => 'required',
                'kode_pos'          => 'required',
                'addr'              => 'required',
                'pembayaran'        => 'required',
                'ket_pembayaran'    => 'required'


      ], [
        '*.required' => 'data tidak boleh kosong',
      ]);
      $profile    = session()->get('profile');
      // get code
      $id_user  = session()->get('profile')->id;
      $id_owner = session()->get('profile')->id_owner;
      
     
            
      
      $form = [
        // data customer
        'id_owner'          => $id_owner,
        'id_user'           => $id_user,
        'sumber_sales'      => $request->get('sumber_sales'),
        'no_tlp'            => $request->get('no_tlp'),
        'nama'              => $request->get('nama'),
        'prov'              => $request->get('prov'),
        'kab'               => $request->get('kab'),
        'kec'               => $request->get('kec'),
        'kode_pos'          => $request->get('kode_pos'),
        'addr'              => $request->get('addr'),
        'pembayaran'          => $request->get('pembayaran'),
        'ket_pembayaran'      => $request->get('ket_pembayaran'),
        'ekspedisi'           => $request->get('ekspedisi'),
        'sub_total'           => $request->get('btotal'),
        'ongkir'              => $request->get('ongkir'),
        'grand_total'         => $request->get('gtotal'),
        //detail barang
        'code'        => $request->get('code'),
        'namabrg'     => $request->get('namabrg'),
        'harga'       => $request->get('harga'),
        'qty'         => $request->get('qty'),
        'diskon'      => $request->get('diskon'),
        'total'       => $request->get('total'),
        'btotal'      => $request->get('btotal'),




      ];
      $url    = '/api/add_order_input/';
      $method = 'POST';
      $route  = 'List Order Input';
      $data   = $form;
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      dd($action);
      return Redirect::route($route) ;
    }

  }

  public function edit_order_input(Request $request , $id){


  if($request->isMethod('GET')){
    $url    = '/api/find_order_input/'.$id;
    $method = 'GET';
    $data   = NULL;
    $crud   = new SendToApi();
    $data   = $crud->crud($url,$method ,$data);
    // dd($data);
    return view('admin.OrderInput.orderinputEdit' , ['OrderInput' => $data]);

    }else{

      $request->validate([

                'sumber_sales'      => 'required',
                'no_tlp'            => 'required',
                'nama'              => 'required',
                'prov'              => 'required',
                'kab'               => 'required',
                'kec'               => 'required',
                'kode_pos'          => 'required',
                'addr'              => 'required',
                'pembayaran'        => 'required',
                'ket_pembayaran'    => 'required'
        ], [
        '*.required' => 'data tidak boleh kosong',
        ]);

        $profile    = session()->get('profile');

        $form = [
        'id'                => $id,
        'id_owner'          => $profile->id,
        'sumber_sales'      => $request->get('sumber_sales'),
        'no_tlp'            => $request->get('no_tlp'),
        'nama'              => $request->get('nama'),
        'prov'              => $request->get('prov'),
        'kab'               => $request->get('kab'),
        'kec'               => $request->get('kec'),
        'kode_pos'          => $request->get('kode_pos'),
        'addr'              => $request->get('addr'),
        'pembayaran'          => $request->get('pembayaran'),
        'ket_pembayaran'      => $request->get('ket_pembayaran'),
        'ekspedisi'           => $request->get('ekspedisi'),
        'sub_total'           => $request->get('btotal'),
        'ongkir'              => $request->get('ongkir'),
        'grand_total'         => $request->get('gtotal'),
         //detail barang
         'code'        => $request->get('code'),
         'namabrg'     => $request->get('namabrg'),
         'harga'       => $request->get('harga'),
         'qty'         => $request->get('qty'),
         'diskon'      => $request->get('diskon'),
         'total'       => $request->get('total'),
         'btotal'      => $request->get('btotal'),
        ];


      $url      = '/api/edit_order_input/'.$id;
      $method   = 'POST';
      $route    = 'List Order Input';
      $data     = $form;
      $crud     = new SendToApi();
      $action   = $crud->crud($url , $method , $data);

      // log_financial

      // $log_finance = [];
      // $log_finance['code']              = OrderInput::generateCode($owner,'KSR');
      // $log_finance['id_user']           = $data['id_user'];
      // $log_finance['id_owner']          = $data['id_owner'];
      // $log_finance['amount']            = $data['amount'];
      // $log_finance['id_differential']   = $data['id_differential'];
      // $log_finance['no_bukti']          = $data['no_bukti'];
      // $log_finance['nama_perkiraan']    = $data['nama_perkiraan'];
      // $log_finance['nama_pendapatan']   = $data['nama_pendapatan'];
      // $log_finance['debit']             = $data['debit'];
      // $log_finance['kredit']            = $data['kredit'];
      // $log_finance['action']            = $data['action'];
      return Redirect::route($route) ;

    }

  }

  public function delete_order_input(Request $request , $id){

    $data = [
      'id'  => $request->get('id')
    ];
    $url    = '/api/delete_order_input/'.$id;
    $method = 'GET';
    $route  = 'List Order Input';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    // dd($action);
    return Redirect::route($route) ;
  }

}
