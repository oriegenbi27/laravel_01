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

use App\Library\SendToApi;
use App\Library\Images;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; 
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class SettingController extends Controller
{
  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }



  public function index(Request $request ){

    if($request->isMethod('Get')){
      $url      = '/api/setting/GetDataSetting';
      $method   = 'GET';
      $route    = 'Setting Dashboard';
      $data     = NULL;
      $crud     = new SendToApi();
      $setting  = $crud->crud($url , $method , $data);
      // dd($setting);
      return view('admin.Setting.setting' , ['data' => $setting]);
    }else{
      $request->validate([
        'nama'    => 'required' ,
        'email'   => 'required',
        'tlp'     => 'required',
        'hp'      => 'required',
        'npwp'    => 'required',
        'prov'    => 'required',
        'kode_pos'  => 'required',
        'addr'    => 'required',
        ], [
        '*.required' => 'data tidak boleh kosong',
        ]);
        $explode = explode('/' , $request->get('prov'));
       

        $file   = $request->file('icon');
        $arFile   = array();
        if(isset($file)){
          $file_path          = $file->getPathname();
          $file_mime          = $file->getMimeType('image');
          $file_uploaded_name = $file->getClientOriginalName();

          $arFile=[
              'name'     => 'images',
              'filename' => $file_uploaded_name,
              'Mime-Type'=> $file_mime,
              'contents' => fopen($file_path, 'r'),
          ];
        }else{
          $arFile =[
            'name'  => 'images',
            'contents'  => "nofile",
          ];
        }

        $data =[
          $arFile, 
          ['name' => 'nama'       , 'contents' => $request->get('nama')],
          ['name' => 'email'      , 'contents' => $request->get('email')],
          ['name' => 'tlp'        , 'contents' => $request->get('tlp')],
          ['name' => 'hp'         , 'contents' => $request->get('hp')],
          ['name' => 'npwp'       , 'contents' => $request->get('npwp')],
          ['name' => 'prov'       , 'contents' => $explode[0]],
          ['name' => 'kab'        , 'contents' => $explode[1]],
          ['name' => 'kec'        , 'contents' => $explode[2]],
          ['name' => 'kel'        , 'contents' => $explode[3]],
          ['name' => 'kode_pos'   , 'contents' => $request->get('kode_pos')],
          ['name' => 'longlat'    , 'contents' => $request->get('longlat')],
          ['name' => 'tipe_bisnis', 'contents' => $request->get('tipe_bisnis')],
          ['name' => 'time'       , 'contents' => $request->get('time')],
          ['name' => 'addr'       , 'contents' => $request->get('addr')],
          
        ];

        // dd($data);
        $url    = '/api/setting/setting_dashboard';
        $method = 'POST';
        $route  = 'Setting Dashboard';
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data, $type="multipart");
     
        // dd($action);
        return Redirect::Route($route);

    }


   }

  public function GetDataSetting(){

    $url    = '/api/GetDataSetting';
    $method = 'GET';
    $route  = 'Setting Dashboard';
    $data   = NULL;


    $crud     = new SendToApi();
    $setting = $crud->crud($url , $method , $data);
    $headers  = 'application/json';
    return response()->json($setting);

  }
  
  public function preferensi(Request $request){

    if($request->isMethod('GET')){
      $url    = "/api/setting/preferensi";
      $method = "GET";
      $data   = NULL;
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      // dd($action); 
      return view('admin.Setting.preferensi' , ['data' => $action]);
    }else{
          $request->validate([
            'tipeakun'    => 'required',
            'nama'        => 'required'
          ],[
            '*.required'  => 'data tidak boleh kosong',
          ]);
          $data = [
            'nama'        => $request->get('nama'),
            'tipeakun'    => $request->get('tipeakun')
          ];

          $route  = "Preferensi ERP";
          $url    = "/api/setting/preferensi";
          $method = "POST";
          $crud   = new SendToApi();
          $action = $crud->crud($url , $method , $data);
          // dd($action);

          
          return Redirect::Route($route);
    }

  }

  function buildTree(array $elements, $parentId = '') {
    $branch = array();
    foreach ($elements as $element) {
      
        if ($element->akun_induk == $parentId) {
            $children = $element->kode_perkiraan;
            if ($children) {
                $element->kode_perkiraan = $children;
            }
            $branch[] = $element; 
        }
    }

    return $branch;
}

  public function preferensi_log(Request $request){
    if($request->isMEthod('GET')){
      if($request->ajax()){
    $route  = "Preferensi LOG";
    $url    = "/api/setting/preferensi";
    $method = "GET";
    $data   = NULL;
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    $DataTables = [];
    $list = [] ;

    // foreach ($action->data as $key => $value) {
    //   $parent           = $value ->akun_induk == NULL ? $value->kode_perkiraan : '';
    //   $kode_perkiraan   = $value->kode_perkiraan;
    //   $list[$parent]['kode_perkiraan'] = $value->kode_perkiraan;
    //   $list[$parent]['nama_parent']    = $value->nama;
    //   $list[$parent][$value->kode_perkiraan]['nama_child'] = $value->nama;
    // }
    // dd($list);

    foreach($action->data as $row){
    
    $DataTables[]=array(
      "Kode Perkiraan"   => ['<ul>
                                  <li>'.$row->akun_induk == NULL ? $row->kode_perkiraan : ''.'</li>
                                    <ul>
                                      <li>'.$row->kode_perkiraan.'</li>
                                    </ul>
                              </ul>'
                            ],
      "tipe_akun"        => ['<ul>
                                  <li>'.$row->tipe_akun.'</li>
                              </ul>'
                          ], 
      "nama"             => ['<ul>
                                <li>'.$row->nama.'</li>
                              </ul>'
                            ],
    );
  };
  return response()->json([
    "draw"  => intval($request->input('draw')),
    "recordsTotal" => $action->data,
    "recordsFiltered" => $action->data,
    "data"  => $DataTables
  ]);

};

$html = $this->htmlBuilder
  ->addColumn([
    'data'  => 'Kode Perkiraan', 
    'name'  => 'kode_perkiraan',  
    'title' => 'Kode Perkiraan',
    'width' =>'10%',
    ''
    ])
  ->addColumn([
    'data'  => 'nama',
    'name'  => 'nama',        
    'title' => 'Nama',
    'width' =>'30%'
    ])
  ->addColumn([
    'data'  => 'tipe_akun',
    'name'  => 'tipe_akun',
    'title' => 'Tipe Akun',
    'width' =>'20%',
    ])
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
              window.location.href="#";
            }'  
      ],
          [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
          [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
          [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
     ],
  ]);
    return view('admin.Setting.prefensilog' ,compact('html'));
  }
}

  

}
