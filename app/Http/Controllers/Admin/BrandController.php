<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// library
use App\Library\SendToApi;
use App\Library\ImagesToBase64;

use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class BrandController extends Controller
{
  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

  public function index(Request $request){

      if($request->ajax()){
      $url    = '/api/GetDataBrand';
      $method = 'GET';
      $route  = 'List Brand';
      $data   = NULL ;
      $crud   = new SendToApi();
      $brand = $crud->crud($url , $method , $data);
      $DataTables = [];
      foreach($brand->data as $row){
        $edit=base64_encode("modif::".$row->id);
        $delete=base64_encode("trans::".$row->id);
  // {{Config::get('constant.endpoint.url')}}/storage/karyawan
        $DataTables[]=array(
          "Images"           => '<img alt="image" class="rounded-circle" width="64" height="64" src="'.Config::get('constant.endpoint.url').'/storage/brand/'.$row->images.'">',
          "Nama"             => $row->nama,
          "Keterangan"       => $row->keterangan,
          "Action"           => '<a href="/brand/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                                 <a href="/brand/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
        );
      };
        return response()->json([
          "draw"  => intval($request->input('draw')),
          "recordsTotal" => $brand->data,
          "recordsFiltered" => $brand->data,
          "data"  => $DataTables
        ]);
  
      };
      $html = $this->htmlBuilder
        ->addColumn(['data' => 'Images' ,         'name' => 'images' ,        'title' => 'Images','width'=>'10%','orderable'=>false])
        ->addColumn(['data' => 'Nama' ,           'name' => 'nama' ,        'title' => 'Name','width'=>'40%'])
        ->addColumn(['data' => 'Keterangan' ,     'name' => 'keterangan' ,  'title' => 'keterangan','width'=>'30%'])
        ->addColumn(['data' => 'Action' ,         'name' => 'action' ,      'title' => 'Action','width'=>'20%','orderable' => false])
        ->parameters([
          'responsive'  => false,
          'dom'         => '<"html5buttons"B>lTfgtip',
          'order'       => [1, 'desc'],
          'buttons'     =>  [
            ['className'=>'btn btn-primary btn-outline','titleAttr'=>'Tambah ','text'=>'<i class="fa fa-sliders" aria-hidden="true"></i>',
                'init'=>'function(api, node, config) {  
                $(node).removeClass(\'dt-button\')
                  }',
                  'action'=>'function ( e, dt, node, config ){
                    window.location.href="/brand/add";
                  }'  
            ],
                [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
           ],
        ]);

        // dd(compact('html'));
  
      return view('admin.Brand.brand' , compact('html'));
  }

  public function ImgToBase64($data){
    
  }

  public function add_brand(Request $request){

    if($request -> isMethod('GET')){
      return view('admin.Brand.brandAdd');
    }else{
      $request->validate([
        'nama'        => 'required',
        'keterangan'  => 'required',
      ],[
        '*.required'  => 'data tidak boleh kosong',
      ]);
      
      $file               = $request->file('file');
      
      if(isset($file)){

            $file_path          = $file->getPathname();
            $file_mime          = $file->getMimeType('image');
            $file_uploaded_name = $file->getClientOriginalName();

            $arFile=[
                'name'      => 'images',
                'filename'  => $file_uploaded_name,
                'Mime-Type' => $file_mime,
                'contents'  => fopen($file_path, 'r'),
            ];
      }else{
        $arFile=['name'      => 'images','contents' => "nofile"];
      }
      $data = [
          $arFile,
          ['name' => 'nama','contents' => $request->get('nama')],
          ['name' => 'keterangan','contents' =>$request->get('keterangan')],
      ];

      $route  = "List Brand";
      $url    = "/api/add_brand";
      $method = "POST"; 
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data,$type="multipart");
      // dd($action);

      return Redirect::Route($route);
    }
  }

  public function find_brand(Request $request, $id){
    $url    = '/api/find_brand/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);
    return response()->json($data);
  }

  public function edit_brand(Request $request){
    $code = base64_decode($request->get('code'));
    $exp  = explode('::',$code);
    $id   = $exp[1];
    if($request->isMethod('GET')){
      $url    = '/api/find_brand/'.$id;
      $method = 'GET';
      $data   = NULL;
      $crud   = new SendToApi();
      $data   = $crud->crud($url,$method,$data);
      return view('admin.Brand.brandEdit' , ['brand' => $data]);
    }else{
      $data   = array();
      $request ->validate([
          'id'          => 'required',
          'nama'        => 'required',
          'keterangan'  => 'required',

      ],[
        '*.required'    => 'data tidak boleh kosong',
      ]);

      $file               = $request->file('file');
      
      if(isset($file)){

            $file_path          = $file->getPathname();
            $file_mime          = $file->getMimeType('image');
            $file_uploaded_name = $file->getClientOriginalName();

            $arFile=[
                'name'      => 'images',
                'filename'  => $file_uploaded_name,
                'Mime-Type' => $file_mime,
                'contents'  => fopen($file_path, 'r'),
            ];
      }else{
        $arFile=['name'      => 'images','contents' => "nofile"];
      }

      $data = [
          $arFile,
          ['name' => 'nama','contents' => $request->get('nama')],
          ['name' => 'keterangan','contents' =>$request->get('keterangan')],
      ];

      $route    = "List Brand";
      $url      = "/api/edit_brand/".$id;
      $method   = "POST";
      $crud     = new SendToApi();
      $action   = $crud->crud($url , $method , $data , $type="multipart");
      return Redirect::Route($route);
    }
  }

  public function delete_brand(Request $request){
    $decode = base64_decode($request->get('code'));
    $id_brand = explode('::' , $decode);
    $id   = $id_brand[1];
    $route    = "List Brand";
    $url      = "/api/delete_brand/".$id;
    $method   = "GET";
    $crud     = new SendToApi();
    $action   = $crud->crud($url , $method , $data = NULL);
    
    // dd($action);
    return Redirect::Route($route);
  }


  public function testupload(Request $request){

    if($request->isMethod('GET')){
      return view('admin.Brand.testupload');
    }else{
      $file = $request->file('file');

      $file     = $request->file('file');
      $encrypt  = new ImagesToBase64();
      $images   = $encrypt->EncryptToBase64($file);
      dd($images);
    }
        
  }
}
?>