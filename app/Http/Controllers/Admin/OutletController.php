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

use App\Library\SendToApi ;
use App\Outlet;
use App\Library\Images ;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class OutletController extends Controller
{

  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }


  public function index(Request $request){

  if($request->ajax()){ 
    $crud = new SendToApi(); 
    $url = '/api/outlet/DataOutlet/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'];
    $method = 'GET';
    $data = NULL;
    $outlet = $crud->crud($url , $method , $data);
    $DataTables = [];

   
    // dd($outlet);
    foreach($outlet->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);

      $btnedit=($row->flag>0?'':'<a href="/outlet/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>');
      $btndelete='<a onClick="return hapus('.$row->id.')" data-id="'.$delete.'" class="btn btn-outline btn-link delete"><i class="fa fa-trash" ></i> '.($row->flag>0?'Active':'Non Active').'</a>';
      
      $DataTables[]=array(
        "date"             => $row->updated_at,
        "nama"             => $row->nama,
        "alamat"           => $row->alamat,
        "awal"             => $row->tgl_awal,
        "akhir"            => $row->tgl_akhir,
        "Action"           => $btnedit.' '.$btndelete,
      );
    } 
    
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $outlet->count,
        "recordsFiltered" => $outlet->count,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'date',               'name' => 'date',       'title' => 'Date'])
      ->addColumn(['data' => 'nama',               'name' => 'nama',       'title' => 'Nama Outlet'])
      ->addColumn(['data' => 'alamat',             'name' => 'alamat',     'title' => 'Alamat Outlet'])
      ->addColumn(['data' => 'awal',               'name' => 'tgl_awal',       'title' => 'Tanggal awal'])
      ->addColumn(['data' => 'akhir',              'name' => 'tgl_akhir',      'title' => 'Tanggal akhir'])
      ->addColumn(['data' => 'Action',             'name' => 'Action',     'title' => 'Action' ,'orderable'=>false])
      
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
                  window.location.href="outlet/add";
                }' 
          ],
         
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);
 
    return view('admin.Outlet.outlet' , compact('html'));


   }

  //  Add Bundling
  public function add_outlet(Request $request){
    if ($request->isMethod('GET')) {
          return view('admin.Outlet.outletAdd');
    }else{
      // $request->validate([
      //                     // 'code'               => 'required',
      //                     'nama'               => 'required',
      //                     'alamat'             => 'required',
      //                     'awal'               => 'required',
      //                     'akhir'              => 'required',
                          
                          
      // ], [
      //   '*.required' => 'data tidak boleh kosong',
      // ]);

     
      
      $data = [
        // 'code' => $request->get('code'),
        'nama' => $request->get('nama'),
        'password' =>$request->get('password'),
        'alamat' => $request->get('alamat'),
        'awal' => $request->get('awal'),
        'akhir' => $request->get('akhir'),

       

      ];



      $url    = '/api/outlet/add_outlet/';
      $method = 'POST';
      $route  = 'List Outlet';
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data );

      // dd($action);
      if ($action->code=="000") {
        return Redirect::Route($route)->with('success', Alert::toast('Berhasil', 'success'));
      }else{
        return Redirect::Route($route)->with('error', Alert::toast('Gagal', 'error'));
      }
    }

  }

  public function jsonbundling(Request $request){



    $crud = new SendToApi();
    $url = '/api/bundling/GetDataBundling';
    $method = 'GET';
    $data = NULL;
    $bundling = $crud->crud($url , $method , $data);
    
    $no=1;
    foreach($bundling->data as $bundling){
        $data[]=array(
            $bundling->id,
            $bundling->code,
            $bundling->judul,
            $bundling->item[0]->nama." + Free ".$bundling->gratis[0]->nama." 1 pcs",
            $bundling->berat,
            $bundling->stock_bundling,
            $bundling->harga,
            );
            
    }
    
    $callback = array(
                'role'=>'',
                'draw' =>'',
                'recordsTotal'=>sizeof($data),
                'recordsFiltered'=>sizeof($data),
                'data'=>$data
            );
    
    header('Content-Type: application/json');
    echo json_encode($callback);



   }

   public function find_outlet(Request $request, $id){
    $url  = '/api/outlet/find_outlet/'.$id;
    $method = 'GET';
    $data   = NULL ;
    $crud   = new SendToApi();
    $data   = $crud->crud($url , $method , $data);
   
    return response()->json($data);
  }

   public function edit_outlet(Request $request){
    $decode = base64_decode($request->get('code'));
    $exp = explode('::', $decode);
    $id  = $exp[1];
   
    if($request->isMethod('GET')){
      $url    = '/api/outlet/find_outlet/'.$id;
      $method = 'GET';
      $data   = NULL ;
      $crud   = new SendToApi();
      $data   = $crud->crud($url , $method,$data);
      // dd($data);
      return view('admin.Outlet.outletEdit' , ['outlet'   => $data]);

    }else{
      // $request->validate([
      //   // 'id'          => 'required',
      //   'nama'        => 'required',
      //   'codegc'        => 'required',
      //   'keterangan'  => 'required',
      // ],[
      //   '*.required'  => 'data tidak boleh kosong',
      // ]);
      $profile    = session()->get('profile');
      $data = [
        'id'          => $id,
        'nama'        => $request->get('nama'),
        'password'    => $request->get('password'),
        'alamat'      => $request->get('alamat'),
        'awal'        => $request->get('awal'),
        'akhir'       => $request->get('akhir'),
        'id_owner'    => $profile->id
      ];
     
      $route  = "List Outlet";
      $url    = "/api/outlet/edit_outlet/".$id;
      $method = "POST";
      $crud   = new SendToApi();
      $action = $crud->crud($url,$method,$data);
      
      if ($action->code=="000") {
        return Redirect::Route($route)->with('success', Alert::toast('Berhasil', 'success'));
      }else{
        return Redirect::Route($route)->with('error', Alert::toast('Gagal', 'error'));
      }
      
    }

  }

  public function delete_outlet(Request $request){
    // $decode = base64_decode($request->get('code'));
    // $exp = explode('::', $decode);
    // $id  = $exp[1];
    $data = [
      'id'  => $request->get('id')
    ];
    
    $url    = '/api/outlet/delete_outlet';
    $method = 'POST';
    $route  = 'List Outlet';
    $crud   = new SendToApi();

    try {
      
          $action = $crud->crud($url , $method , $data);

          echo json_encode($action);

          } catch (Exception $e) {
           
            return back()->with('error', Alert::toast('Data Gagal dihapus', 'error'));
       }
  }

}
