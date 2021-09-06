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


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class VarianController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }


  public function index(Request $request){

    
  if($request->ajax()){
    $url    = '/api/GetDataVarian';
    $method = 'GET';
    $route  = 'List Varian';
    $data   = NULL ;

    $crud   = new SendToApi();
    $varian = $crud->crud($url , $method , $data);
    $DataTables = [];
    foreach($varian->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);

      $DataTables[]=array(
        "Code"             => $row->code,
        "Nama"             => $row->nama,
        "Keterangan"       => $row->keterangan,
        "Action"           => '<a href="/varian/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="/varian/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    }
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $varian->data,
        "recordsFiltered" => $varian->data,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'Code',          'name' => 'codet',       '     title' => 'Code'])
      ->addColumn(['data' => 'Nama',          'name' => 'nama',             'title' => 'Nama'])
      ->addColumn(['data' => 'Keterangan',    'name' => 'keterangan',       'title' => 'Keterangan'])
      ->addColumn(['data' => 'Action' ,       'name' => 'action' ,          'title' => 'Action','ordertable' => false])
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
                  window.location.href="/varian/add";
                }'  
          ],
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);

    return view('admin.Varian.varian' , compact('html'));
  }


  public function add_varian(Request $request){

    if($request -> isMethod('GET')){
      return view('admin.Varian.varianAdd');
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
        'id_owner'    => $profile->id,
        'code'        => $request->code,
        'nama'        => $request->get('nama'),
        'keterangan'  => $request->get('keterangan')
        
      ];

      $route  = "List Varian";
      $url    = "/api/add_varian";
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);

      return Redirect::Route($route);
    }
  }

  public function edit_varian(Request $request){
    $code = base64_decode($request->get('code'));
    $exp  = explode('::',$code);
    $id   = $exp[1];
    if($request->isMethod('GET')){
      $url    = '/api/find_varian/'.$id;
      $method = 'GET';
      $data   = NULL ;
      $crud   = new SendToApi();
      $data   = $crud->crud($url , $method,$data);
      // dd($data);
      return view('admin.Varian.varianEdit' , ['varian' => $data]);
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
      $route  = "List Varian";
      $url    = "/api/edit_varian/".$id;
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);

      // dd($action);
      return Redirect::Route($route);
    }
  }

  public function find_varian(Request $request, $id){
    $url  = '/api/find_varian/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);

    return response()->json($data);
  }

  public function delete_varian(Request $request){
    $data   = [
      'id'  => $request->get('id'),
    ];
    $code = base64_decode($request->get('code'));
    $exp  = explode('::',$code);
    $id   = $exp[1];
    $url    = '/api/delete_varian/'.$id;
    $method = 'GET';
    $route  = 'List Varian';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);

    return Redirect::Route($route);
  }

}
?>