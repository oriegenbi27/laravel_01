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
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Library\SendToApi;
use App\Produk;
use App\JenisBarang;
use App\Satuan;
use App\Purchasing_Controller;
use App\Mail\CetakPurchasingMail;
use App\Library\Images ;

use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class PurchasingController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }


  public function index(Request $request){

    if($request->ajax()){

    $url    = '/api/GetDataPurchasing';
    $method = 'GET';
    $route  = 'List Purchasing';
    $data   = NULL;


    $crud     = new SendToApi();
    $purchasing = $crud->crud($url , $method , $data);
    $DataTables = [];
    foreach($purchasing->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);
      $bayar=base64_encode("modif::".$row->id);

      $DataTables[]=array(
        "date"               => $row->updated_at,
        "code"               => $row->id,
        "supplier"           => $row->supplier,
        "npwp"               => $row->npwp,
        "email"              => $row->email,
        "alamat"             => $row->alamat,
        "category"           => $row->category,
        "status"=>'<button type="button" class="btn  btn-xs">'.$row->status.'</button>',
        "tgl_kirim"          => $row->tgl_kirim,
        "id_owner"           => $row->id_owner,
        "Action"             => '<a href="/purchasing/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                                 <a href="/purchasing/delete?code='.$delete.'" class="btn btn-outline btn-link delete"><i class="fa fa-trash" ></i> Non Active</a>
                                 <a href="/purchasing/bayar?code='.$bayar.'" class="btn btn-outline btn-link delete"><i class="" ></i>Bayar</a>'
                                 ,
      );
    }
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $purchasing->data,
        "recordsFiltered" => $purchasing->data,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'code' ,                'name' => 'code' ,                 'title' => 'Code'])
      ->addColumn(['data' => 'date',                 'name' => 'created_at',            'title' => 'Date'])
      ->addColumn(['data' => 'supplier' ,            'name' => 'supplier' ,             'title' => 'Supplier'])
      ->addColumn(['data' => 'npwp' ,                'name' => 'npwp' ,                 'title' => 'NPWP'])
      ->addColumn(['data' => 'email' ,               'name' => 'email' ,                'title' => 'NPWP'])
      ->addColumn(['data' => 'alamat' ,              'name' => 'alamat' ,               'title' => 'Alamat'])
      ->addColumn(['data' => 'category' ,            'name' => 'category' ,             'title' => 'Category'])
      ->addColumn(['data' => 'status' ,              'name' => 'status' ,               'title' => 'status'])
      ->addColumn(['data' => 'tgl_kirim',            'name' => 'tgl_kirim',             'title' => 'Tgl Kirim'])
      ->addColumn(['data' => 'id_owner' ,            'name' => 'id_owner' ,             'title' => 'Id owner'])
      ->addColumn(['data' => 'Action' ,              'name' => 'action' ,               'title' => 'Action','ordertable' => false])
      ->parameters([
        'responsive'  => true,
        'dom'         => '<"html5buttons"B>lTfgtip',
        'order'       => [0, 'desc'],
        'buttons'     =>  [
          ['className'=>'btn btn-primary btn-outline','titleAttr'=>'Tambah ','text'=>'<i class="fa fa-sliders" aria-hidden="true"></i>',
              'init'=>'function(api, node, config) {  
              $(node).removeClass(\'dt-button\')
                }',
                'action'=>'function ( e, dt, node, config ){
                  window.location.href="/purchasing/add";
                }'  
          ],
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);

    return view('admin.Purchasing.purchasing' , compact('html'));


   }

   public function autocomplete(Request $request)
    {
        $data = Produk::select('nama')
                ->where('nama', 'like', "%{$request->term}%")
               ->pluck('nama');
        return response()->json($data);
    }

    public function autocompletecategory(Request $request)
    {
        $data = JenisBarang::select('nama')
                ->where('nama', 'like', "%{$request->term}%")
                ->pluck('nama');

        return response()->json($data);
    }
    public function autocompletesatuan(Request $request)
    {
        $data = Satuan::select('code')
                ->where('code', 'like', "%{$request->term}%")
                ->pluck('code');

        return response()->json($data);
    }

    public function send_mail(Request $request, $email)
    {
        $details = [
            'title' => 'Mail from Bizplan.com',
            'body' => 'This is for testing email using smtp'
            ];

            \Mail::to($email)->send(new \App\Mail\CetakPurchasingMail($details));

            dd("Email sudah terkirim.");
    }

    public function jsonpurchasing(){

        $url    = '/api/GetDataPurchasing/';
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $purchasing   = $crud->crud($url,$method ,$data);
        $no=1;

        foreach($purchasing->purchasing as $a){
            $data[]=array(

                $a->id,
                $a->supplier,
                $a->npwp,
                $a->email,
                $a->alamat,
                $a->category,
                );

        }

        $callback = array(
                    'role'=>0,
                    'draw' =>'',
                    'recordsTotal'=>10,
                    'recordsFiltered'=>10,
                    'data'=>$data
                );
        header('Content-Type: application/json');
        echo json_encode($callback);



       }

  public function GetDataPurchasing(){

    $url    = '/api/GetDataPurchasing';
    $method = 'GET';
    $route  = 'List Purchasing';
    $data   = NULL;


    $crud     = new SendToApi();
    $purchasing = $crud->crud($url , $method , $data);
    $headers  = 'application/json';
    return response()->json($purchasing);

  }

  public function purchasing_cetak(Request $request , $id){
    // if($request->isMethod('POST')){
    //     $profile    = session()->get('profile');

    //         $form = [
    //         'id'                => $id,
    //         'tgl_kirim'         => $request->get('tgl_kirim'),
    //         ];


    //       $url      = '/api/purchasing_cetak/'.$id;
    //       $method   = 'POST';
    //       $route    = 'List Purchasing';
    //       $data     = $form;
    //       $crud     = new SendToApi();
    //       $action   = $crud->crud($url , $method , $data);
    //       dd($action);
    //       return Redirect::route($route) ;

    // }else{

        $url    = '/api/purchasing_cetak/'.$id;
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $purchasing   = $crud->crud($url,$method ,$data);
        // dd($purchasing);
        // $setting_crud   = new SendToApi();
        // $setting_url    = '/api/GetDataSetting';
        // $setting_method = 'GET';
        // $setting_data   = NULL;
        // $setting_action = $setting_crud->crud($setting_url , $setting_method , $setting_data);
        // dd($purchasing);
        return view('admin.Purchasing.cetak' , ['purchasing' => $purchasing]);

    // }






  }



  public function add_purchasing(Request $request){


    if($request->isMethod('GET')){

    $setting_crud   = new SendToApi();
    $setting_url    = '/api/GetDataSetting';
    $setting_method = 'GET';
    $setting_data   = NULL;
    $setting_action = $setting_crud->crud($setting_url , $setting_method , $setting_data);

    $produk_crud   = new SendToApi();
    $produk_url    = '/api/GetDataJenisBarang';
    $produk_method = 'GET';
    $produk_data   = NULL;
    $produk_action = $produk_crud->crud($produk_url , $produk_method , $produk_data);
 
    $purchasing_crud   = new SendToApi();
    $purchasing_url    = '/api/GetDataPurchasingOldest';
    $purchasing_method = 'GET';
    $purchasing_data   = NULL;
    $purchasing_action = $purchasing_crud->crud($purchasing_url , $purchasing_method , $purchasing_data);


        return view('admin.Purchasing.purchasingAdd' , ['setting' => $setting_action, 'purchasing' => $purchasing_action, 'jenis' => $produk_action]);
      }else{
        $profile    = session()->get('profile');
        $form = [
          // Data Purchasing
          
          'id_owner'            => $profile->id,
          'supplier'            => $request->get('supplier'),
          'email'               => $request->get('email'),
          'npwp'                => $request->get('npwp'),
          'alamat'              => $request->get('addr'),
          'category'            => $request->get('category'),
          'totalbayar'          => $request->get('totalbayar'),
          
          // Data DetailPurchasing
          'jenis'               => $request->get('jenis'),
          'nama_item'           => $request->get('nama_item'),
          'harga'               => $request->get('harga'),
          'qty'                 => $request->get('qty'),
          'diskon'              => $request->get('diskon'),
          'satuan'              => $request->get('satuan'),
          'totbarang'           => $request->get('totbarang'),
        ];
        $url    = '/api/add_purchasing/';
        $method = 'POST';
        $route  = 'List Purchasing';
        $data   = $form;
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data);

        dd($action);
        return Redirect::route($route);

      }
    //   return view('search');

  }


  public function edit_purchasing(Request $request){

    $decode = base64_decode($request->get('code'));
    $id_purchasing = explode('::' , $decode);
    $id   = $id_purchasing[1];

    if($request->isMethod('GET')){
        $url    = '/api/find_purchasing/'.$id;
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $data   = $crud->crud($url,$method ,$data);
        // dd($data);
        return view('admin.Purchasing.purchasingEdit' , ['purchasing' => $data]);



        }else{

        //   $request->validate([

        //             'sumber_sales'      => 'required',
        //             'no_tlp'            => 'required',
        //             'nama'              => 'required',
        //             'prov'              => 'required',
        //             'kab'               => 'required',
        //             'kec'               => 'required',
        //             'kode_pos'          => 'required',
        //             'addr'              => 'required',
        //             'pembayaran'        => 'required',
        //             'ket_pembayaran'    => 'required'
        //     ], [
        //     '*.required' => 'data tidak boleh kosong',
        //     ]);

            $profile    = session()->get('profile');

            $form = [
            'id'                => $id,
            'id_owner'          => $profile->id,
            // Data Purchasing
            'id_owner'            => $profile->id,
            'supplier'            => $request->get('supplier'),
            'email'               => $request->get('email'),
            'npwp'                => $request->get('npwp'),
            'alamat'              => $request->get('addr'),
            'category'            => $request->get('category'),

            // Data DetailPurchasing
            'nama_item'           => $request->get('nama_item'),
            'harga'               => $request->get('harga'),
            'qty'                 => $request->get('qty'),
            'diskon'              => $request->get('diskon'),
            'satuan'              => $request->get('satuan'),
            ];


          $url      = '/api/edit_purchasing/'.$id;
          $method   = 'POST';
          $route    = 'List Purchasing';
          $data     = $form;
          $crud     = new SendToApi();
          $action   = $crud->crud($url , $method , $data);
          dd($action);
          return Redirect::route($route) ;

        }

  }

  public function detail_purchasing(Request $request){

    $decode = base64_decode($request->get('code'));
    // $id_brand = explode('::' , $decode);
    $id   = $decode;
    // dd($decode);

    if($request->isMethod('GET')){
        $url    = '/api/find_purchasing/'.$id;
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $data   = $crud->crud($url,$method ,$data);
        // dd($data);
        return view('admin.Purchasing.purchasingDetail' , ['purchasing' => $data]);



        }else{

        //   $request->validate([

        //             'sumber_sales'      => 'required',
        //             'no_tlp'            => 'required',
        //             'nama'              => 'required',
        //             'prov'              => 'required',
        //             'kab'               => 'required',
        //             'kec'               => 'required',
        //             'kode_pos'          => 'required',
        //             'addr'              => 'required',
        //             'pembayaran'        => 'required',
        //             'ket_pembayaran'    => 'required'
        //     ], [
        //     '*.required' => 'data tidak boleh kosong',
        //     ]);

            $profile    = session()->get('profile');

            $form = [
            'id'                => $id,
            'id_owner'          => $profile->id,
            // Data Purchasing
            'id_owner'            => $profile->id,
            'supplier'            => $request->get('supplier'),
            'email'               => $request->get('email'),
            'npwp'                => $request->get('npwp'),
            'alamat'              => $request->get('addr'),
            'category'            => $request->get('category'),

            // Data DetailPurchasing
            'nama_item'           => $request->get('nama_item'),
            'harga'               => $request->get('harga'),
            'qty'                 => $request->get('qty'),
            'diskon'              => $request->get('diskon'),
            'satuan'              => $request->get('satuan'),
            ];


          $url      = '/api/edit_purchasing/'.$id;
          $method   = 'POST';
          $route    = 'List Purchasing';
          $data     = $form;
          $crud     = new SendToApi();
          $action   = $crud->crud($url , $method , $data);
          dd($action);
          return Redirect::route($route) ;

        }

  }


  public function edit_tglkirim(Request $request , $id){


            $profile    = session()->get('profile');

            $form = [
            'id'                => $id,
            'id_owner'          => $profile->id,

            'tgl_kirim'           => $request->get('tgl_kirim'),
            ];


          $url      = '/api/edit_tglkirim/'.$id;
          $method   = 'POST';
          $route    = '/purchasing_cetak/'.$id;
          $data     = $form;
          $crud     = new SendToApi();
          $action   = $crud->crud($url , $method , $data);
          // dd($action);
          return redirect($route) ;



  }

  // Bayar
  public function bayar_purchasing(Request $request){

    $decode = base64_decode($request->get('code'));
    $id_brand = explode('::' , $decode);
    $id   = $id_brand[1];

    if($request->isMethod('GET')){
        $url    = '/api/find_purchasing/'.$id;
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $data   = $crud->crud($url,$method ,$data);
        
        $bank_url    = '/api/GetDataBank';
        $bank_method = 'GET';
        $bank_data   = NULL;
        $bank_crud   = new SendToApi();
        $bank_action   = $crud->crud($bank_url,$bank_method ,$bank_data);
        // dd($data);
        return view('admin.Purchasing.bayar' , ['purchasing' => $data , 'bank' => $bank_action]);



        }else{

       
            $images_lib     = new Images();
            $images_filter  = $images_lib->ImagesFilter($request->file('bukti'));
            $profile    = session()->get('profile');

            $form = [
              $images_filter,
              ['name' => 'ponomor',               'contents' => $request->get('ponomor')],
              ['name' => 'ket',                   'contents' => $request->get('ket')],
              ['name' => 'tglbayar',              'contents' => $request->get('tglbayar')],
              ['name' => 'bank',                  'contents' => $request->get('bank')],
              ['name' => 'totalbayar',            'contents' => $request->get('totalbayar')],
              
              
             
            ];


          $url      = '/api/bayar_purchasing/'.$id;
          $method   = 'POST';
          $type   = 'multipart';
          $route    = 'List Purchasing';
          $data     = $form;
          $crud     = new SendToApi();
          $action   = $crud->crud($url , $method , $data, $type);
          dd($action);
          return Redirect::route($route) ;

        }

  }

  public function delete_purchasing(Request $request , $id){
    
    $data = [
      'id'  => $request->get('id')
    ];
    $url    = '/api/delete_purchasing/'.$data;
    $method = 'GET';
    $route  = 'List Purchasing';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    // dd($action);
    return Redirect::route($route) ;
  }

}
