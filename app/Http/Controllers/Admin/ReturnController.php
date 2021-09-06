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
use App\Purchasing;
use App\Library\Images;

class ReturnController extends Controller
{

    public function index(Request $request ){

        if($request->isMethod('Get')){
            return view('admin.Purchasing.return');
        }else{
        $profile    = session()->get('profile');

        $form = [
          // Data Purchasing
          'id_owner'            => $profile->id,
          'akun'                => $request->get('akun'),
          'tipe'                => $request->get('tipe'),
          'date'                => $request->get('date'),
          'ponomor2'            => $request->get('ponomor2'),
          // Data Array
          'id_detail'           => $request->get('iddetails'),
          'id_purchasing'       => $request->get('idpurchasing'),
          //   'qty'            => $request->get('qtybarang'),
          'return'              => $request->get('return'),
          'nama_item'           => $request->get('namabrg')


        ];
        $url    = '/api/add_return/';
        $method = 'POST';
        $route  = 'Warehouse ERP';
        $data   = $form;
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data);

        dd($action);
        // return Redirect::route($route);

        }
    }

    public function search(Request $request){
        
        $id = base64_encode($request->get('ponomor'));
        $url    = '/api/find_ponomor/'.$id;
        $method = 'GET';
        $data   = NULL;
        $crud   = new SendToApi();
        $purchasing   = $crud->crud($url,$method ,$data);
        // dd($purchasing);
        if ($purchasing->code=="001") {
            return view('admin.Warehouse.form')->with('success', Alert::error('Data tidak ditemukan', 'Maaf nomor PO tidak ditemukan'));
      }
      elseif ($purchasing->data->status=="completed") {
            return view('admin.Warehouse.form')->with('success', Alert::Alert('Purchasing Completed', 'Maaf ! Purchasing Order tersebut sudah selesai'));
      }
      
      else{
       return view('admin.Warehouse.form' , ['purchasing' => $purchasing])->with('success', Alert::success('Berhasil', 'success'));
      
      }

    }








}
