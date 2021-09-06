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
use App\Library\Images ;

class PosController extends Controller
{
   public function index(){

    $crud   = new SendToApi();
    $url    = '/api/GetDataProduk';
    $method = 'GET';
    $route  = 'Erp Pos';
    $data   = NULL;
    $produk = $crud->crud($url , $method , $data);

    $brand_crud   = new SendToApi();
    $brand_url    = '/api/GetDataBrand';
    $brand_method = 'GET';
    $brand_data   = NULL;
    $brand_produk = $brand_crud->crud($brand_url , $brand_method , $brand_data);
    
    $jenis_crud   = new SendToApi();
    $jenis_url    = '/api/GetDataJenisBarang';
    $jenis_method = 'GET';
    $jenis_data   = NULL;
    $jenis_produk = $jenis_crud->crud($jenis_url , $jenis_method , $jenis_data);
    
    $tmp_crud   = new SendToApi();
    $tmp_url    = '/api/GetDataDetailTmpPos';
    $tmp_method = 'GET';
    $tmp_data   = NULL;
    $tmp_produk = $tmp_crud->crud($tmp_url , $tmp_method , $tmp_data);
   
    $setting_crud   = new SendToApi();
    $setting_url    = '/api/GetDataSetting';
    $setting_method = 'GET';
    $setting_data   = NULL;
    $setting_action = $setting_crud->crud($setting_url , $setting_method , $setting_data);
   
    // dd($produk);
    return view('admin.Pos.index' , ['setting' => $setting_action ,'produk' => $produk , 'brand' => $brand_produk , 'jenis' => $jenis_produk , 'tmp' => $tmp_produk ]);
   }

   public function addToCart(Request $request){
    $id     = $request->get('id');  
    $crud   = new SendToApi();
    $url    = '/api/find_produk/'.$id;
    $method = 'GET';
    $route  = 'Erp Pos';
    $data   = NULL;
    $produk = $crud->crud($url , $method , $data);

    
    $url_temp     = '/api/find_tmp_pos_produk/'.$id;
    $method_temp  = 'GET';
    $crud_tmp     = new SendToApi();
    $tmp_pos      = $crud_tmp->crud($url_temp , $method_temp , NULL);

    $data_temp = [];
    $qty_find  = 1;
    $url_temp  = '';

    if(empty($tmp_pos->data)){
      $data_temp_action['id_produk'] = $id;
      $data_temp_action['qty']  = 1;      
      $url_temp_action          = '/api/add_tmp_pos';
    }else{
      $url_temp_action     = '/api/edit_tmp_pos';
      foreach($tmp_pos->data as $find_tmp){
        $data_temp_action['qty'] = $find_tmp->qty + $qty_find;
        $data_temp_action['id']  = $find_tmp->id;
      }
    }
    $method_temp_action     = 'POST';
    $tmp_action             = $crud_tmp->crud($url_temp_action , $method_temp_action , $data_temp_action);

    return response()->json($data_temp_action);   
  }

  public function getDetailPos(){

    $crud   = new SendToApi();
    $url    = '/api/GetDataDetailTmpPos/';
    $method = 'GET';
    $route  = 'Erp Produk';
    $data   = NULL;
    $action = $crud->crud($url , $method , $data);


    return response()->json($action);
  }

  public function pos_cetak(Request $request){

    $bayar    = $request->get('bayar');

    $crud   = new SendToApi();
    $url    = '/api/GetDataDetailTmpPos/';
    $method = 'GET';
    $route  = 'Erp Produk';
    $data   = NULL ;
    $action = $crud->crud($url , $method , $data);

    $isi = [];
    foreach($action->TmpPos as $row){
      $isi['id_produk'] = $row->id_produk;
      $isi['qty']       = $row->qty;
    }
    
    // return response()->json($action);
    return view('admin.Pos.cetak' , ['data' => $action , 'bayar' => $bayar]);

  }

  public function CreateDetail(Request $request){
    $crud   = new SendToApi();
    $url    = '/api/GetDataDetailTmpPos/';
    $method = 'GET';
    $route  = 'Erp Produk';
    $data   = NULL;
    $action = $crud->crud($url , $method , $data);

    
    $dataDetail = array();
    $arr        = [];

    $rand     = rand(0,1000);
    $count    = count($action->TmpPos);
    $id_user  = $request->session()->get('profile')->id;
    $id_owner = $request->session()->get('profile')->id_owner;
    $code     = 'POS'.Date('Ymd').$id_user.$id_owner.$rand;
    $dataDetail['ttl_item'] = $count;
    $dataDetail['bayar']    = $request->get('bayar');
    foreach($action->TmpPos as $row){
      $dataDetail['code']      = $code;
      $dataDetail['id_user']   = $request->session()->get('profile')->id;
      $dataDetail['id_owner']  = $request->session()->get('profile')->id_owner;
      $dataDetail['id_produk'] = $row->id_produk;
      $dataDetail['qty']       = $row->qty;
      $dataDetail['harga']     = $row->join_produk[0]->harga;
      $dataDetail['diskon']    = $row->join_produk[0]->diskon;
      array_push($arr , $dataDetail);
    };
      $url_detail    = '/api/pos/CreateDetail';
      $method_detail = 'POST';
      $action_detail = $crud->crud($url_detail , $method_detail , $arr);
     dd($action_detail);
   return true;
  }

}    