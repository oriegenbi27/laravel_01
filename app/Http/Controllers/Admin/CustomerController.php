<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Config;
use App\Customer;
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


class CustomerController extends Controller
{

  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

  public function index(Request $request){
    // $user = User::where('verification_token', $token)->first();

  if($request->ajax()){
    $url = '/api/DataCustomer/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'];
    // dd($url);
    $method = 'GET';
    $route  = 'Erp Costumer';
    $data = NULL;
    $crud     = new SendToApi();
    $customer = $crud->crud($url , $method , $data); 
   
    $DataTables = [];
    foreach($customer->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);

      $btnedit=($row->flag>0?'':'<a href="/customer/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>');
      $btndelete='<a onClick="return hapus('.$row->id.')" data-id="'.$delete.'" class="btn btn-outline btn-link delete"><i class="fa fa-trash" ></i> '.($row->flag>0?'Active':'Non Active').'</a>';


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
        "Action"           =>$btnedit.' '.$btndelete
      );
    }
    return response()->json([
      "draw"  => intval($request->input('draw')),
      "recordsTotal" => $customer->count,
      "recordsFiltered" => $customer->count,
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
      ->addColumn(['data' => 'Kota/provinsi' ,     'name' => 'kab' ,      'title' => 'Kota / Kabupaten'])
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
                  window.location.href="/customer/add";
                }'  
          ],
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);

      // dd($html); 
      return view('admin.Customer.customer' , compact('html'));
   }

  public function GetDataCustomer(){

    $url    = '/api/GetDataCustomer';
    $method = 'GET';
    $route  = 'Erp Costumer';
    $data   = NULL;


    $crud     = new SendToApi();
    $customer = $crud->crud($url , $method , $data);
    $headers  = 'application/json';
    return response()->json($customer);

  }

  public function add_customer(Request $request){

    if($request->isMethod('GET')){
      $data = array();
      $data['title']  = 'Add Customer';
      $data['back']   = 'Customer';
      $data['url_back'] = url('/customer');
      return view('admin.Customer.customerAdd' , ['menu' => $data]);
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
      $url    = '/api/add_customer/';
      $method = 'POST';
      $route  = 'Erp Costumer';
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      
      // dd($action);
      return Redirect::route($route) ;

    }

  }

  public function edit_customer(Request $request){

  $decode = base64_decode($request->get('code'));

  $id_customer = explode('::' , $decode);

  
  if($request->isMethod('GET')){
    
    $data           = array();
    $url            = '/api/find_customer/'.$id_customer[1];
    $method         = 'GET';
    $data           = NULL;
    $crud           = new SendToApi();
    $data['data']   = $crud->crud($url,$method ,$data);

    $data['title']  = 'Edit Customer';
    $data['back']   = 'Customer';
    $data['url_back'] = url('/customer');

    return view('admin.Customer.customerEdit' , ['data' => $data]);
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
      $url      = '/api/edit_customer/'.$id;
      $method   = 'POST';
      $route    = 'Erp Costumer';
      $crud     = new SendToApi();
      $action   = $crud->crud($url , $method , $data);
      // dd($action);
      return Redirect::route($route) ;

    }

  }

  public function delete_customer(Request $request){
   
    $data = [
      'id'  => $request->get('id')
    ];
    
    $url    = '/api/delete_customer';
    $method = 'POST';
    $route  = 'Erp Customer';
    $crud   = new SendToApi();

    try {
          $action = $crud->crud($url , $method , $data);
          echo json_encode($action);

          } catch (Exception $e) {
            return back()->with('error', Alert::toast('Data Gagal dihapus', 'error'));
       }
  }

}
