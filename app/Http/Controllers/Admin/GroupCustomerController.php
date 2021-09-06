<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Config;
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

class GroupCustomerController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

  public function index(Request $request){

    if($request->ajax()){
    $url    = '/api/GetDataGroupCustomer';
    $method = 'GET';
    $route  = 'List Group Customer';
    $data   = NULL ;

    $crud   = new SendToApi();
    $GroupCustomer = $crud->crud($url , $method , $data);
    $DataTables = [];

    // dd($GroupCustomer);
      foreach($GroupCustomer->data as $row){
        $edit = base64_encode("modif::".$row->id);
        $delete = base64_encode("modif::".$row->id);
        
        $DataTables[] = array(
          "Code"        => $row->code,
          "Nama"        => $row->nama,
          "Keterangan"  => $row->keterangan,
          "Action"      => '<a href="/group-customer/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                            <a href="/group-customer/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
        );
      }
      return response()->json([
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => $GroupCustomer->data,
        "recordsFiltered" => $GroupCustomer->data,
        "data"            => $DataTables
      ]);
    };
    $html = $this->htmlBuilder
    ->addColumn(['data' => 'Code',         'name' => 'code',           'title' => 'Code'])
    ->addColumn(['data' => 'Nama' ,        'name' => 'nama' ,          'title' => 'Name'])
    ->addColumn(['data' => 'Keterangan' ,  'name' => 'keterangan' ,    'title' => 'Keterangan'])
    ->addColumn(['data' => 'Action' ,      'name' => 'action' ,        'title' => 'Action','ordertable' => false])
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
                window.location.href="/group-customer/add";
              }'  
        ],
            [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
            [ 'extend'=>'csv',  'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
            [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
    ],
    ]);
    // 
    return view('admin.GroupCustomer.groupcustomer' , compact('html'));
  }


  public function add_group_customer(Request $request){
 
    if($request -> isMethod('GET')){
    $url  = '/api/GetDataGroupCustomer';
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);
    // dd($data->data[2]->level);
      return view('admin.GroupCustomer.groupcustomerAdd' , ['GroupCustomer'   => $data]);
    }else{
      $request->validate([
        'nama'        => 'required',
        'code'        => 'required',
        'level'       => 'required',
        'diskon'      => 'required',
        'keterangan'  => 'required',
      ],[
        '*.required'  => 'data tidak boleh kosong',
      ]);

      $profile    = session()->get('profile');
      $data = [
        'code'        => $request->get('code'),
        'nama'        => $request->get('nama'),
        'level'       => $request->get('level'),
        'diskon'      => $request->get('diskon'),
        'keterangan'  => $request->get('keterangan'),
        'id_owner'    => $profile->id
      ];

      $route  = "List Group Customer";
      $url    = "/api/add_group_customer";
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      dd($action);
      return Redirect::Route($route);
    }
  }

  public function edit_group_customer(Request $request){
    $enc = base64_decode($request->get('code'));
    $exp = explode('::', $enc);
    $id  = $exp[1];
   
    if($request->isMethod('GET')){
      $url    = '/api/find_group_customer/'.$id;
      $method = 'GET';
      $data   = NULL ;
      $crud   = new SendToApi();
      $data   = $crud->crud($url , $method,$data);
     
      return view('admin.GroupCustomer.groupcustomerEdit' , ['GroupCustomer'   => $data]);

    }else{
      $request->validate([
        // 'id'          => 'required',
        'nama'        => 'required',
        'codegc'        => 'required',
        'keterangan'  => 'required',
      ],[
        '*.required'  => 'data tidak boleh kosong',
      ]);
      $profile    = session()->get('profile');
      $data = [
        'id'          => $id,
        'nama'        => $request->get('nama'),
        'codegc'      => $request->get('codegc'),
        'level'       => $request->get('level'),
        'diskon'      => $request->get('diskon'),
        'keterangan'  => $request->get('keterangan'),
        'id_owner'    => $profile->id
      ];
      // $id=$request->get('id');
      $route  = "List Group Customer";
      $url    = "/api/edit_group_customer/".$id;
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);

      dd($action);
      return Redirect::Route($route);
    }
  }

  public function find_group_customer(Request $request, $id){
    $url  = '/api/find_group_customer/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);

    return response()->json($data);
  }

  public function delete_group_customer(Request $request){
    $enc = base64_decode($request->get('code'));
    $exp = explode('::', $enc);
    $id  = $exp[1];

    $url    = '/api/delete_group_customer/'.$id;
    $method = 'GET';
    $route  = 'List Group Customer';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    // dd($action);
    return Redirect::Route($route);
  }

}
?>
