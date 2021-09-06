<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserConfirmationMail;
use Config;
use Adldap\Adldap;
use App\Customer;
use App\User;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Redirect;
use Session;
use Validator;
use JWTAuth;
use App\Library\Images ;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('APITokenJWT', ['except' => [
            'login', 'register' ,'userVerification'     ]
        ]);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.register');
        }else{

                $parameter = $request->only('fullname', 'email', 'password', 'phone', 'address');

                if ($this->checkUser($parameter['email']) != null) {
                    return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
                }

                $user = new User();
                $user->fullname = $parameter['fullname'];
                $user->email = strtolower($parameter['email']);
                $user->password = Hash::make($parameter['password']);
                $user->phone = $parameter['phone'];


                $user->verified = false;
                $user->verification_token = Str::random(100);
                $user->save();

                $response = [];
                if($user){
                  $response = [
                      'message' => 'Berhasil Delete ',
                      'data'    => $user,
                      'code' => '000',
                      'tipe' => 'sukses',
                    ];
                }else{
                  $response = [
                    'message' => 'Gagal Delete ',
                    'code' => '001',
                    'tipe' => 'gagal',
                  ];
                }

                if (env('APP_ENV') == 'production') {
                 Mail::to($user->email)->send(new UserConfirmationMail($user, route('user-verification', [$user->verification_token])));
                }
                return response()->json($response);
        }

    }

    private function checkUser($email)
        {
            $user = User::where('email', $email)->first();
            return $user;
        }

    public function userVerification(Request $request, $token)
    {
        $user = User::where('verification_token', $token)->first();
        if (is_null($user)) {
            return 'Not valid';
        } else {
            $user->verified = true;
            $user->verification_token = null;
            $user->save();

            return 'User verified';
        }
    }

    public function login(Request $request)
    {

        $parameter = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($parameter)) {
            return response()->json(['message' => 'Email atau Password tidak sesuai.'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    public function me(Request $request)
    {
        if ($request->isMethod('GET')) {
            $user = User::where('id', auth()->user()->id)->first();
            return response()->json($user);
        } else {

        }

    }

    public function add_customer(Request $request){

      // if($request->isMethod('GET')){
      //   return view('admin.customerAdd');
      // }else{

      //   $parameter = $request->only('nama' ,
      //                               'email' ,
      //                               'tlp' ,
      //                               'hp' ,
      //                               'npwp' ,
      //                               'prov' ,
      //                               'kab' ,
      //                               'kec' ,
      //                               'kel' ,
      //                               'kode_pos' ,
      //                               'addr' );

      //   if ($this->checkUser($parameter['email']) != null) {
      //     return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
      //    }

      //    $customer = new Customer();
      //    $customer->nama = $parameter['nama'];
      //    $customer->email = strtolower($parameter['email']);
      //    $customer->tlp = $request($parameter['tlp']);
      //    $customer->hp = $request($parameter['hp']);
      //    $customer->npwp = $request($parameter['npwp']);
      //    $customer->prov = $request($parameter['prov']);
      //    $customer->kab = $request($parameter['kab']);
      //    $customer->kec = $request($parameter['kec']);
      //    $customer->kel = $request($parameter['kel']);
      //    $customer->kode_pos = $request($parameter['kode_pos']);
      //    $customer->addr = $request($parameter['addr']);

      //    $customer->verification_token = Str::random(100);


      //    $response = [
      //      'message' => 'Berhasil Menambahkan Customer',
      //      'Customer' => $customer
      //    ];

      //    return response()->json($response);
      // }



      return response()->json(get_headers());
    }

    public function privilage(Request $request){
        $parameter = $request->all();
        for ($i=0; $i < sizeof($parameter['user']); $i++) {

            $user=User::find($parameter['user'][$i]);
            $user->level=$parameter['privilage'];
            $user->save();

        }

        $response = [];
        if($user){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $user,
              'code' => '000',
              'tipe' => 'sukses',
            ];
        }else{
          $response = [
            'message' => 'Gagal Delete ',
            'code' => '001',
            'tipe' => 'gagal',
          ];
        }

          return response()->json($response);

    }

    public function karyawan(Request $request){
        if ($request->isMethod('GET')) {

             $id_owner = auth()->user()->id_owner;
            $parameter = $request->all();
            $serching='';

            $colom=['updated_at','fullname','','','phone','email','ktp',''];
            $orderby=$colom[$parameter['order']];
            $sort=$parameter['dir'];

            if (!empty($parameter['serch'])) {
                $serching=$parameter['serch'];
                $data=User::select('fullname','ktp','id','updated_at','address','email','phone','level')->with(['level'])
                        ->where(function($query) use ($serching){
                            $query->where('fullname', 'LIKE', '%'.$serching.'%')
                                  ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                                  ->orWhere('email', 'LIKE', '%'.$serching.'%');
                        })
                        ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
            }else{


                $data=User::select('fullname','ktp','id','updated_at','address','email','phone','level')->with(['level'])
                         ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
                }
            $array=array('data'=>$data,'count'=>User::count());
            return response()->json($array);

        }else{
            $parameter = $request->only('nama' ,
                                        'ktp' ,
                                        'tempat_lahir',
                                        'tgl_lahir',
                                        'email' ,
                                        'kontak' ,
                                        'alamat' ,
                                        'images');

            $id_owner       = auth()->user()->id_owner;
            $data['nama'] = $parameter['nama'];
            $data['file'] = $request->file('images');
            $data['path'] = 'public/karyawan';
            $data['images'] = $parameter['images'];

            $move = new Images();
            $action = $move->MovePath($data);

            $user                     = new User();
            $user->fullname           = strtolower($parameter['nama']);
            $user->ktp                = strtolower($parameter['ktp']);
            $user->tempat_lahir       = strtolower($parameter['tempat_lahir']);
            $user->tgl_lahir          = $parameter['tgl_lahir'];
            $user->email              = strtolower($parameter['email']);
            $user->phone              = strtolower($parameter['kontak']);
            $user->address            = strtolower($parameter['alamat']);
            $user->photo              = $action;
            $user->id_owner           = strtolower($id_owner);

            $user->save();

            $response = [];
            if($user){
              $response = [
                  'message' => 'Berhasil Delete ',
                  'data'    => $user,
                  'code' => '000',
                  'tipe' => 'sukses',
                ];
            }else{
              $response = [
                'message' => 'Gagal Delete ',
                'code' => '001',
                'tipe' => 'gagal',
              ];
            }

            return response()->json($response,200);
        }

    }

    public function Findkaryawanid(Request $request , $id){
        $user     = User::find($id);
        $response = [];
        if($user){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $user,
              'code' => '000',
              'tipe' => 'sukses',
            ];
        }else{
          $response = [
            'message' => 'Gagal Delete ',
            'code' => '001',
            'tipe' => 'gagal',
          ];
        }
        return response()->json($response);
      }

}
