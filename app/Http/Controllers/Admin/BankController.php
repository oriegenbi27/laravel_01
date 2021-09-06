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

use App\Library\SendToApi;

class BankController extends Controller
{

  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }

    public function index(Request $request){
        // $user = User::where('verification_token', $token)->first();

      if($request->ajax()){
        $url    = '/api/GetDataBank';
        $method = 'GET';
        $route  = 'Erp Bank';
        $data   = NULL;
        $crud     = new SendToApi();
        $bank = $crud->crud($url , $method , $data);
        $DataTables = [];
        foreach($bank->data as $row){
          $edit=base64_encode("modif::".$row->id);
          $delete=base64_encode("trans::".$row->id);
    
          $DataTables[]=array(
            "code"             => $row->code,
            "cabang"           => $row->cabang,
            "no_rek"           => $row->no_rek,
            "keterangan"       => $row->keterangan,
            "Action"           => '<a href="/bank/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                                   <a href="/bannk/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
          );
        }
          return response()->json([
            "draw"  => intval($request->input('draw')),
            "recordsTotal" => $bank->data,
            "recordsFiltered" => $bank->data,
            "data"  => $DataTables
          ]);
    
        };
        $html = $this->htmlBuilder
          ->addColumn(['data' => 'code',        'name' => 'code',        'title' => 'code'])
          ->addColumn(['data' => 'cabang' ,     'name' => 'cabang' ,     'title' => 'cabang'])
          ->addColumn(['data' => 'no_rek' ,     'name' => 'no_rek' ,     'title' => 'no_rek'])
          ->addColumn(['data' => 'keterangan' , 'name' => 'keterangan' , 'title' => 'keterangan'])
          ->addColumn(['data' => 'Action' ,     'name' => 'action' ,     'title' => 'Action','ordertable' => false])
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
                      window.location.href="/bank/add";
                    }'  
              ],
                  [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                  [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                  [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
          ],
          ]);
          // dd($html);
        return view('admin.Bank.bank' , compact('html'));


       }

       public function GetDataBank(){

        $url    = '/api/GetDataBank';
        $method = 'GET';
        $route  = 'Erp bank';
        $data   = NULL;


        $crud     = new SendToApi();
        $bank = $crud->crud($url , $method , $data);
        $headers  = 'application/json';
        return response()->json($bank);
        // dd($bank);


      }

  public function add_bank(Request $request){

    if($request->isMethod('GET')){
      return view('admin.Bank.bankAdd');
    }else{
      $request->validate([
                'code'    => 'required' ,
                'cabang'   => 'required',
                'no_rek'     => 'required',
                'keterangan'      => 'required',


      ], [
        '*.required' => 'data tidak boleh kosong',
      ]);
      $profile    = session()->get('profile');
      $form = [
        'code'          => $request->get('code'),
        'cabang'        => $request->get('cabang'),
        'no_rek'        => $request->get('no_rek'),
        'keterangan'    => $request->get('keterangan'),
        'id_owner'      => $profile->id,

      ];

      $url    = '/api/add_bank/';
      $method = 'POST';
      $route  = 'Erp Bank';
      $data   = $form;
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data);
      // dd($action);
      return Redirect::route($route) ;


    }

  }

  public function edit_bank(Request $request ){
    $decode = base64_decode($request->get('code'));

    $id_customer = explode('::' , $decode);
    $id = $id_customer[1];
    if($request->isMethod('GET')){
      $url    = '/api/find_bank/'.$id;
      $method = 'GET';
      $data   = NULL;
      $crud   = new SendToApi();
      $data   = $crud->crud($url,$method ,$data);
      // dd($token = $request->header('Authorization'));
      return view('admin.Bank.bankEdit' , ['bank' => $data]);
      }else{
        $request->validate([
          'code'        => 'required',
          'cabang'      => 'required',
          'no_rek'      => 'required',
          'keterangan'  => 'required',
          'id_owner'    => 'required',

          ], [
          '*.required' => 'data tidak boleh kosong',
          ]);

          $form = [
            'id'            => $request->get('code'),
            'code'          => $request->get('code'),
            'cabang'        => $request->get('cabang'),
            'no_rek'        => $request->get('no_rek'),
            'keterangan'    => $request->get('keterangan'),
            'id_owner'      => $request->get('id_owner')

          ];

        $url      = '/api/edit_bank/'.$id;
        $method   = 'POST';
        $route    = 'Erp Bank';
        $data     = $form;
        $crud     = new SendToApi();
        $action   = $crud->crud($url , $method , $data);
        return Redirect::route($route) ;



      }

    }

    public function delete_bank(Request $request){
      $decode = base64_decode($request->get('code'));

      $id_customer = explode('::' , $decode);
      $id = $id_customer[1];
        $url    = '/api/delete_bank/'.$id;
        $method = 'GET';
        $route  = 'Erp Bank';
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data);

        return Redirect::Route($route);
        // dd($action);
      }


}
