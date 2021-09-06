<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Config;
use App\JenisBarang;
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
class JenisBarangController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }
  public function index(Request $request){

    if($request->ajax()){
    $url    = '/api/GetDataJenisBarang';
    $method = 'GET';
    $route  = 'List Jenis Barang';
    $data   = NULL ;

    $crud   = new SendToApi();
    $JenisBarang = $crud->crud($url , $method , $data);
    $DataTables = [];
    foreach($JenisBarang->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);

      $DataTables[]=array(
        "code"             => $row->code,
        "nama"             => $row->nama,
        "keterangan"       => $row->keterangan,
        "Action"           => '<a href="'.route('Edit Jenis Barang').'?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="'.route('Delete Jenis Barang').'?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    }
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $JenisBarang->data,
        "recordsFiltered" => $JenisBarang->data,
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

    return view('admin.JenisBarang.jenisbarang' ,  compact('html'));
  }


  public function add_jenis_barang(Request $request){

    if($request -> isMethod('GET')){
      return view('admin.JenisBarang.jenisbarangAdd');
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

      $route  = "List Jenis Barang";
      $url    = "/api/add_jenis_barang";
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);

      return Redirect::Route($route);
    }
  }

  public function edit_jenis_barang(Request $request){

    $decode = base64_decode($request->get('code'));

    $id_jenis = explode('::' , $decode);
  
    $id = $id_jenis[0];
    if($request->isMethod('GET')){
      $url    = '/api/find_jenis_barang/'.$id;
      $method = 'GET';
      $data   = NULL ;
      $crud   = new SendToApi();
      $data   = $crud->crud($url , $method,$data);
      // dd($data);
      return view('admin.JenisBarang.jenisbarangEdit' , ['JenisBarang'   => $data]);

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
      $route  = "List Jenis Barang";
      $url    = "/api/edit_jenis_barang/".$id;
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);


      return Redirect::Route($route);
    }
  }

  public function find_jenis_barang(Request $request, $id){
    $url  = '/api/find_jenis_barang/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);

    return response()->json($data);
  }

  public function delete_jenis_barang(Request $request , $id){
    $decode = base64_decode($request->get('code'));
    $id_jenis = explode('::' , $decode);
    $id     = $id_jenis[1];
    
    $url    = '/api/delete_jenis_barang/'.$id;
    $method = 'GET';
    $route  = 'List Jenis Barang';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    // dd($action);
    return Redirect::Route($route);
  }

}
?>
