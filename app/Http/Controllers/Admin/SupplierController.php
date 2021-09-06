<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Config;
use App\Supplier;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Library\SendToApi;
use App\Library\Images ;
use Session;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class SupplierController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

  public function index(Request $request){
    // $user = User::where('verification_token', $token)->first();

  if($request->ajax()){
    $url    = '/api/GetDataSupplier';
    $method = 'GET';
    $route  = 'Erp Costumer';
    $crud     = new SendToApi();
    $supplier = $crud->crud($url , $method , NULL);

    $DataTables = [];
    foreach($supplier->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);

      $DataTables[]=array(
        "date"             => $row->updated_at,
        "nama"             => $row->nama,
        "email"            => $row->email,
        "NoTelp"           => $row->tlp,
        "NoHP"             => $row->hp,
        "NPWP"             => $row->npwp,
        "Provinsi"         => $row->prov,
        "Kota/provinsi"    => $row->kab,
        "Kecamatan"        => $row->kec,
        "Kelurahan"        => $row->kel,
        "Kode Pos"         => $row->kode_pos,
        "Addres"           => $row->addr,
        "Action"           => '<a href="/supplier/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="/supplier/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    }
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $supplier->data,
        "recordsFiltered" => $supplier->data,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'date',               'name' => 'date',       'title' => 'Date'])
      ->addColumn(['data' => 'nama' ,              'name' => 'nama' ,     'title' => 'Name'])
      ->addColumn(['data' => 'email' ,             'name' => 'email' ,    'title' => 'Email'])
      ->addColumn(['data' => 'NoTelp' ,            'name' => 'tlp' ,      'title' => 'Telpon'])
      ->addColumn(['data' => 'NoHP' ,              'name' => 'hp' ,       'title' => 'NoHP'])
      ->addColumn(['data' => 'NPWP' ,              'name' => 'npwp' ,     'title' => 'NPWP'])
      ->addColumn(['data' => 'Provinsi' ,          'name' => 'prov' ,     'title' => 'Provinsi'])
      ->addColumn(['data' => 'Kota/provinsi' ,               'name' => 'kab' ,      'title' => 'Kota / Kabupaten'])
      ->addColumn(['data' => 'Kecamatan' ,         'name' => 'kec' ,      'title' => 'Kecamatan'])
      ->addColumn(['data' => 'Kelurahan' ,         'name' => 'kel' ,      'title' => 'Kelurahan'])
      ->addColumn(['data' => 'Kode Pos',           'name' => 'kode_pos',  'title' => 'Kode Pos'])
      ->addColumn(['data' => 'Addres' ,            'name' => 'addr' ,     'title' => 'Address'])
      ->addColumn(['data' => 'Action' ,            'name' => 'action' ,   'title' => 'Action','ordertable' => false])
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
                  window.location.href="/supplier/add";
                }'  
          ],
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);

      // dd($html);
      return view('admin.Supplier.supplier' , compact('html'));
   }

  public function GetDataSupplier(){

    $url    = '/api/GetDataSupplier';
    $method = 'GET';
    $route  = 'Erp Supplier';
    $data   = NULL;


    $crud     = new SendToApi();
    $supplier = $crud->crud($url , $method , $data);
    $headers  = 'application/json';
    return response()->json($supplier);

  }

  public function jsonsupplier(){

    $crud = new SendToApi();
    $url = '/api/GetDataSupplier';
    $method = 'GET';
    $route = 'List Supplier';
    $data = NULL;
    $supplier = $crud->crud($url , $method , $data);
    $no=1;

    foreach($supplier->data as $a){
        $data[]=array(

            $a->code,
            $a->nama,
            $a->email,
            $a->npwp,
            $a->hp,
            $a->addr,
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

  public function add_supplier(Request $request){

    if($request->isMethod('GET')){
      $data = array();
      $data['title']  = 'Add Suppler';
      $data['back']   = 'Supplier';
      $data['url_back'] = url('/supplier');
      return view('admin.Supplier.supplierAdd' , ['menu' => $data]);
    }else{
      $request->validate([
        'nama'    => 'required' ,
        'email'   => 'required',
        'tlp'     => 'required',
        'hp'      => 'required',
        'npwp'    => 'required',
        'prov'    => 'required',
        'addr'    => 'required'
      ], [
      '*.required' => 'data tidak boleh kosong',
      ]);
      $explode   = explode('/' , $request->get('prov'));
      $data = [
      'nama'      => $request->get('nama'),
      'email'     => $request->get('email'),
      'tlp'       => $request->get('tlp'),
      'hp'        => $request->get('hp'),
      'npwp'      => $request->get('npwp'),
      'prov'      => $explode[0],
      'kab'       => $explode[1],
      'kec'       => $explode[2],
      'kel'       => $explode[3],
      'addr'      => $request->get('addr')
      ];
      $url    = '/api/add_supplier/';
      $method = 'POST';
      $route  = 'Erp Supplier';
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      // dd($action);
      return Redirect::route($route) ;

    }

  }

  public function edit_supplier(Request $request){

    $code = base64_decode($request->get('code'));
    $exp  = explode('::',$code);
    $id   = $exp[1];

    if($request->isMethod('GET')){
      $data           = array();
      $url            = '/api/find_supplier/'.$id;
      $method         = 'GET';
      $data           = NULL;
      $crud           = new SendToApi();
      $data['data']   = $crud->crud($url,$method ,$data);

      $data['title']  = 'Edit Supplier';
      $data['back']   = 'Supplier';
      $data['url_back'] = url('/supplier');

      // dd();
      return view('admin.Supplier.supplierEdit' , ['data' => $data]);
      }else{

        $request->validate([
          'id'      => 'required',
          'nama'    => 'required' ,
          'email'   => 'required',
          'tlp'     => 'required',
          'hp'      => 'required',
          'npwp'    => 'required',
          'prov'    => 'required',
          'addr'    => 'required'
        ], [
        '*.required' => 'data tidak boleh kosong',
        ]);
        $explode   = explode('/' , $request->get('prov'));
        $data = [
        'id'        => $request->get('id'),
        'nama'      => $request->get('nama'),
        'email'     => $request->get('email'),
        'tlp'       => $request->get('tlp'),
        'hp'        => $request->get('hp'),
        'npwp'      => $request->get('npwp'),
        'prov'      => $explode[0],
        'kab'       => $explode[1],
        'kec'       => $explode[2],
        'kel'       => $explode[3],
        'addr'      => $request->get('addr')
        ];

      $url      = '/api/edit_supplier/'.$id;
      $method   = 'POST';
      $route    = 'Erp Supplier';
      $crud     = new SendToApi();
      $action   = $crud->crud($url , $method , $data);
      // dd($action);
      return Redirect::route($route) ;

    }

  }

  public function delete_supplier(Request $request , $id){

    $data = [
      'id'  => $request->get('id')
    ];
    $url    = '/api/delete_supplier/'.$id;
    $method = 'GET';
    $route  = 'Erp Supplier';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    dd($action);
    // return Redirect::route($route) ;
  }

}
