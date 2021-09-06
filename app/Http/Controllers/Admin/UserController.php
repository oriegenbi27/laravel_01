<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Config;
use App\User;
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



class UserController extends Controller
{
    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
    $this->htmlBuilder = $htmlBuilder;
    }

    public function login(request $request)
    {
        if ($request->isMethod('GET')) {
            $data = Session::get('authsession');

            if (isset($data)) {

                if ($data == '01') {
                            return redirect()->intended('home');
                    } else {
                            return view('auth.login');
                        }
                    } else {
                        return view('auth.login');
                    }
                } else {
                    $validator = Validator::make($request->all(), [
                        'email' => 'required',
                        'password' => 'required',
                    ]);


                    if ($validator->fails()) {
                        return back()->with(['message' => 'Username dan password tidak boleh kosong']);
                    } else {

                        $client = new Client();
                        $url = Config::get('constant.endpoint.url') . '/api/login';
                        try {
                            $response = $client->request('post', $url, [
                                'form_params' => [
                                    'email' => $request->get('email'),
                                    'password' => $request->get('password'),
                                ],
                            ]);
                            $body = $response->getBody();
                            $obj = json_decode($body, true);
                            $data['ka_token'] = $obj['access_token'];
                            $data['status'] = "01";
                            Session::put('authsession', $data['status']);
                            Session::put('ka_token', $data['ka_token']);
                            $profile = $this->profile($data['ka_token']);
                            Session::put('profile', $profile);
                            return redirect()->intended('home');
                        } catch (Exception $e) {
                            $data['status'] = "99";
                            Session::put('authsession', $data['status']);
                            return back()->with(['message' => 'Maaf, username atau password yang Kamu masukan salah']);
                        }
                    }
        }
    }

    public function profile($token)
    {
        $url = Config::get('constant.endpoint.url') . '/api/me';
        $client = new Client();
        $header = ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'];
        $response = $client->request('GET', $url, ['headers' => $header]);
        $body = $response->getBody()->getContents();
        $profile = json_decode($body);
        return $profile;
    }

    public function karyawan(request $request){
    if($request->isMethod('GET')){
        if ($request->ajax()) {

                $url    = '/api/karyawan/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'];
                $method = 'GET';
                $data   = null;
                $crud   = new SendToApi();
                $data   = $crud->crud($url,$method,$data);
                $DataTables=[];
                foreach($data->data as $row){
                    $edit=base64_encode("modif::".$row->id);
                    $delete=base64_encode("trans::".$row->id);

                    $DataTables[]=array(
                        "date"=>$row->updated_at,
                        "nama"=>$row->fullname,
                        "cek"=>'<input id="'.$row->id.'" class="chekprivilagelist" name="privilage[]" value="'.$row->id.'" type="checkbox">',
                        "levels"=>$row->level[0]->nama,
                        "kontak"=>$row->phone,
                        "email"=>$row->email,
                        "idno"=>$row->ktp,
                        "action"=>'<a href="/karyawan/add?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                                    <a href="/karyawan/add?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
                    );
                }
                return response()->json([
                    "draw" => intval($request->input('draw')),
                    "recordsTotal"    => $data->count,
                    "recordsFiltered" => $data->count,
                    "data" => $DataTables
                ]);
            }
           $html = $this->htmlBuilder
            ->addColumn(['data' => 'date', 'name' => 'date', 'title' => 'Date'])
            ->addColumn(['data' => 'nama', 'name' => 'nama', 'title' => 'Name'])
            ->addColumn(['data'=>'cek','name'=>'cek','title'=>'#','orderable'=>false ])
            ->addColumn(['data' => 'levels', 'name' => 'levels', 'title' => 'Level','orderable'=>false ])
            ->addColumn(['data' => 'kontak', 'name' => 'kontak', 'title' => 'Telepon'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'idno', 'name' => 'idno', 'title' => 'KTP'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action','orderable'=>false ])
           ->parameters([
            'responsive' => true,
            'dom' => '<"html5buttons"B>lTfgtip',
            'order' => [0,'desc'],
           'buttons' => [
                            ['className'=>'btn btn-primary btn-outline','titleAttr'=>'Tambah Data Customer','text'=>'<i class="fa fa-sliders" aria-hidden="true"></i>',
                                'init'=>'function(api, node, config) {
                                $(node).removeClass(\'dt-button\')
                                  }',
                                  'action'=>'function ( e, dt, node, config ){
                                      showmodalprivilege();
                                  }'
                            ],
                                [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                                [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                                [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
                        ],
                    ]);

            return view('admin.Karyawan.index',compact('html'));
        }else{

            $form=[
                'user'      => $request->get('privilage'),
                "privilage"=>$request->get('flag')
            ];

            $url    = '/api/karyawan/privilage/';
            $method = 'POST';
            $route  = 'Erp Karyawan';
            $data   = $form;
            $crud   = new SendToApi();
            $action = $crud->crud($url , $method , $data);
                header('Content-Type: application/json');
                echo json_encode($action);
                exit();

        }

    }

    public  function privilage(request $request){
        $url    = '/api/GetDataJabatan';
        $method = 'GET';
        $data   = null;
        $crud   = new SendToApi();
        $data   = $crud->crud($url,$method,$data);

        $option ='<div class="form-group row">
                <div class="col-sm-6">
                <div class="input-group m-b">
                    <div class="input-group-prepend">
                        <button tabindex="-1" class="btn btn-white" type="button">Silahkan Pilih Privilage</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"></button>
                        <ul class="dropdown-menu">

                        ';
        foreach($data->data as $row){
            $option .='<li><a id="changeprivilage'.$row->id.'"  data-id="'.$row->id.'" data-text="'.$row->nama.'"  onclick="return changeprivilage(this)" >'.$row->nama.'</a></li>';
        }

        $option .='</ul>
                    </div>
                    </div></div>
                    <label id="privilagetext" class="col-sm-6 col-form-label"></label>
                    </div>';
        $arr=array(
            'title'=>'Silahkan Pilih Hak Akses User',
            'html'=>$option
        );
        header('Content-Type: application/json');
		echo json_encode($arr);
        exit();
    }

    public function created(Request $request){
        if($request->isMethod('GET')){
            $code=$request->input('code');
            if(!is_null($code)){
                $id=base64_decode($code);
                $url    = '/api/karyawan/find/'.explode('::',$id)[1];
                $method = 'GET';
                $data   = null;
                $crud   = new SendToApi();
                $data   = $crud->crud($url,$method,$data);
                $flag=$data->data->flag;
                $data=$data->data;
            }else{
            $flag=0;
            $data=[];
            }
            return view('admin.Karyawan.form',['flag' => $flag,'data'=>$data]);
        }else{

            $request->validate([
                'nama'               => 'required',
                'ktp'                => 'required',
                'tempat_lahir'       => 'required',
                'tgl_lahir'          => 'required',
                'email'              => 'required',
                'kontak'             => 'required',
                'alamat'             => 'required',
                ], [
                '*.required' => 'data tidak boleh kosong',
                ]);


                $images_lib     = new Images();
                $images_filter  = $images_lib->ImagesFilter($request->file('images'));

                $data = [
                            $images_filter,
                            ['name' => 'nama',            'contents' => $request->get('nama')],
                            ['name' => 'ktp',             'contents' => $request->get('ktp')],
                            ['name' => 'tempat_lahir',    'contents' => $request->get('tempat_lahir')],
                            ['name' => 'tgl_lahir',       'contents' => $request->get('tgl_lahir')],
                            ['name' => 'email',           'contents' => $request->get('email')],
                            ['name' => 'kontak',          'contents' => $request->get('kontak')],
                            ['name' => 'alamat',          'contents' => $request->get('alamat')],
                        ];

                $url    = '/api/karyawan/';
                $method = 'POST';
                $type   = 'multipart';
                $route  = 'Erp Karyawan';
                $crud   = new SendToApi();
                $action = $crud->crud($url , $method , $data , $type);

                return Redirect::route($route) ;




        }

    }


}
