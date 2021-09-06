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

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

// library
use App\Library\SendToApi;
use App\Library\ImagesToBase64;

class SubJenisController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

  public function index(Request $request){

  if($request->ajax()){
    $url    = '/api/GetDataSubJenis';
    $method = 'GET';
    $route  = 'List Jenis Barang';
    $data   = NULL ;

    $crud   = new SendToApi();
    $SubJenis = $crud->crud($url , $method , $data);

    $DataTables = [];
    foreach($SubJenis->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);
 
      $DataTables[]=array(
        "code"             => $row->code,
        "nama"             => $row->nama,
        "keterangan"       => $row->keterangan,
        "Action"           => '<a href="/jenis-barang/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="/jenis-barang/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    }
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $SubJenis->data,
        "recordsFiltered" => $SubJenis->data,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'code',               'name' => 'code',        'title' => 'Code'])
      ->addColumn(['data' => 'nama' ,              'name' => 'nama' ,       'title' => 'Name'])
      ->addColumn(['data' => 'keterangan' ,        'name' => 'keterangan' , 'title' => 'Keterangan'])
      ->addColumn(['data' => 'Action' ,            'name' => 'action' ,     'title' => 'Action','ordertable' => false])
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
                  window.location.href="/jenis-barang/add";
                }'  
          ],
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);
    return view('admin.SubJenis.subjenis' , compact('html'));
  }


  public function add_sub_jenis(Request $request){

    if($request -> isMethod('GET')){
      return view('admin.SubJenis.subjenisAdd');
    }else{
      $request->validate([
        'nama'        => 'required',
        'code'        => 'required',
        'keterangan'  => 'required',
      ],[
        '*.required'  => 'data tidak boleh kosong',
      ]);

      $profile    = session()->get('profile');
      $data = [
        'code'        => $request->code,
        'nama'        => $request->get('nama'),
        'keterangan'  => $request->get('keterangan')

      ];

      $route  = "List Sub Jenis";
      $url    = "/api/add_sub_jenis";
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);

      return Redirect::Route($route);
    }
  }

  public function edit_sub_jenis(Request $request){
    $decode = base64_decode($request->get('code'));
    $exp    = explode('::' , $decode);
    $id     = $exp[1];
    if($request->isMethod('GET')){
      $url    = '/api/find_sub_jenis/'.$id;
      $method = 'GET';
      $data   = NULL ;
      $crud   = new SendToApi();
      $data   = $crud->crud($url , $method,$data);

      return view('admin.SubJenis.subjenisEdit' , ['SubJenis'   => $data]);

    }else{
      $request->validate([
        'id'          => 'required',
        'nama'        => 'required',
        'code'        => 'required',
        'keterangan'  => 'required'
      ],[
        '*.required'  => 'data tidak boleh kosong',
      ]);
      $profile    = session()->get('profile');
      $data = [
        'id'          => $request->get('id'),
        'nama'        => $request->get('nama'),
        'code'        => $request->get('code'),
        'keterangan'  => $request->get('keterangan'),
        'id_owner'    => $profile->id
      ];
      $route  = "List Sub Jenis";
      $url    = "/api/edit_sub_jenis/".$id;
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);


      return Redirect::Route($route);
    }
  }

  public function find_jenis_barang(Request $request){
    $decode = base64_decode($request->get('code'));
    $exp    = explode('::' , $decode);
    $id     = $exp[1];
    
    $url  = '/api/find_jenis_barang/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);

    return response()->json($data);
  }

  public function delete_sub_jenis(Request $request , $id){
    $data   = [
      'id'  => $request->get('id'),
    ];

    $url    = '/api/delete_sub_jenis/'.$id;
    $method = 'GET';
    $route  = 'List Sub Jenis';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    // dd($action);
    return Redirect::Route($route);
  }

}
?>
