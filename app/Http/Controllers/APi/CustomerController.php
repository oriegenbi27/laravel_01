<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Customer ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    private function checkUser($email)
    {
        $id_owner = auth()->user()->id_owner;
        $customer = Customer::where('email', $email)
                            ->where('id_owner' , $id_owner)
                            ->first();
        return $customer;
    }

    public function DataCustomer(Request $request){
      $id_owner = auth()->user()->id_owner;
        $parameter = $request->all();
        $serching='';
  
        $colom= ['updated_at','nama','','','','','','','','','','',''];
        $orderby=$colom[$parameter['order']];
        $sort=$parameter['dir'];
  
        if (!empty($parameter['serch'])) {
          $serching=$parameter['serch'];
          $customer=Customer::where('id_owner' , $id_owner)
                  ->where(function($query) use ($serching){
                      $query->where('nama', 'LIKE', '%'.$serching.'%');
                            // ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                            // ->orWhere('email', 'LIKE', '%'.$serching.'%');
                  })
                  ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
      }else{
  
     
          $customer=Customer::where('id_owner' , $id_owner)
                   ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();

         
          
        }
      $array=array('data'=>$customer,'count'=>Customer::count());
      return response()->json($array);
      
    }
   
    public function GetDataCustomer(){
      $id_owner = auth()->user()->id_owner;

      $customer = customer::where('id_owner' , $id_owner)->get()->toArray();

      $response = [];
      if($customer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $customer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);

    }

    public function find_customer($id){
      $id_owner = auth()->user()->id_owner;
      $customer = Customer::find($id);
      $response = [];
      if($customer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $customer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);
    }

    public function add_customer(Request $request){

      if($request->isMethod('GET')){
        return view('admin.customerAdd');
      }else{

        $parameter = $request->only('nama' ,
                                    'email' ,
                                    'tlp' ,
                                    'hp' ,
                                    'npwp' ,
                                    'prov' ,
                                    'kab' ,
                                    'kec' ,
                                    'kel' ,
                                    'addr',
                                    'id_owner' );

        if ($this->checkUser($parameter['email']) != null) {
          return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
         }
         
         $customer           = new Customer();
         $customer->nama     = strtolower($parameter['nama']);
         $customer->email    = strtolower($parameter['email']);
         $customer->tlp      = strtolower($parameter['tlp']);
         $customer->hp       = strtolower($parameter['hp']);
         $customer->npwp     = strtolower($parameter['npwp']);
         $customer->prov     = strtolower($parameter['prov']);
         $customer->kab      = strtolower($parameter['kab']);
         $customer->kec      = strtolower($parameter['kec']);
         $customer->kel      = strtolower($parameter['kel']);
         $customer->addr     = strtolower($parameter['addr']);
         $customer->id_owner = auth()->user()->id_owner;
         $customer->save();
         $response = [];
         if($customer){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $customer,
               'code' => '000',
               'tipe' => 'sukses',
             ];
         }else{
           $response = [
             'message' => 'Gagal ',
             'code' => '001',
             'tipe' => 'gagal',
           ];
         }

         return response()->json($response,200);
      }


    }
    public function edit_customer(Request $request){

      if($request->isMethod('GET')){
        $data = array();
        $data['title']  = 'Add Customer';
        $data['back']   = 'Customer';
        $data['url_back'] = url('/customer');
        return view('admin.customerEdit' , ['menu' => $data]);
      }else{


        $parameter = $request->only('id',
                                    'nama' ,
                                    'email' ,
                                    'tlp' ,
                                    'hp' ,
                                    'npwp' ,
                                    'prov' ,
                                    'kab' ,
                                    'kec' ,
                                    'kel' ,
                                    'addr',
                                    'id_owner');

        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }

         $id = $parameter['id'];
         $customer          = Customer::find($id);
         $customer->nama    = strtolower($parameter['nama']);
         $customer->email   = strtolower($parameter['email']);
         $customer->tlp     = strtolower($parameter['tlp']);
         $customer->hp      = strtolower($parameter['hp']);
         $customer->npwp    = strtolower($parameter['npwp']);
         $customer->prov    = strtolower($parameter['prov']);
         $customer->kab     = strtolower($parameter['kab']);
         $customer->kec     = strtolower($parameter['kec']);
         $customer->kel     = strtolower($parameter['kel']);
         $customer->addr    = strtolower($parameter['addr']);
         $customer->id_owner = auth()->user()->id_owner;

         $customer->save();
         $response = [];
         if($customer){
           $response = [
               'message' => 'Berhasil ',
               'data'    => $customer,
               'code' => '000',
               'tipe' => 'sukses',
             ];
         }else{
           $response = [
             'message' => 'Gagal ',
             'code' => '001',
             'tipe' => 'gagal',
           ];
         }

         return response()->json($response);
      }


    }

    public function delete_customer(Request $request){
      $parameter = $request->all();
      $customer = Customer::where('id' , $parameter['id'] )->first();
      $flag=$customer->flag;

      if($flag>0){
        $customer->update(['flag'=>0]);
      }else{
        $customer->update(['flag'=>1]);
      }
      
      $massage=($flag>0?'non aktifkan':'aktifkan');

      $response = [];
      
      if($customer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $customer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

      return response()->json($response,200);
    }

}
