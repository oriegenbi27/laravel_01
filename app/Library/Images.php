<?php
namespace App\Library;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class Images extends Controller
{
  public function ImagesFilter($data){
    $extension      =  $data->getClientOriginalExtension();

    // valid extension
    $ValidExtension = array("jpeg" , "png" , "jpg");

    // Check extension

    if(in_array(strtolower($extension) , $ValidExtension)){
        $file_size          = $data->getSize();
        // check size
        //if($file_size <= 20000){
        if($file_size > 0){
          $file_path          = $data->getPathname();
          $file_mime          = $data->getMimeType('image');
          $file_uploaded_name = $data->getClientOriginalName();
          $arFile=[
              'name'            => 'images',
              'filename'        => $file_uploaded_name,
              'size'            => $file_size,
              'Mime-Type'       => $file_mime,
              'contents'        => fopen($file_path, 'r'),
          ];
        return $arFile ;
        }
      }else{
        $arFile=['name'      => 'images','contents' => "nofile"];
        return $arFile ;
      }
  }

  public function MovePath($data){
    
    $photo = $data['file'];

    $nama_file  = $data['path'].'/'.$data['images'];
    
    $disk  =  Storage::exists($data['images']);
    if($disk == TRUE){
      $filename = preg_replace('/\s+/', '',$data['nama']).time().'.'.$photo->getClientOriginalExtension();
      $file_delete = unlink(storage_path('/app/'.$data['images']));
      if($file_delete){
          $file = Storage::putFileAs(
          $data['path'], $photo, $filename
        );
        return $filename ;
      }
    }else{
      $filename = preg_replace('/\s+/', '',$data['nama']).time().'.'.$photo->getClientOriginalExtension();
      $storeFile = Storage::putFileAs(
        $data['path'], $photo, $filename
      );
      return $filename;
    }
    
  }

  public function DeletePath($data){
    
    $nama_file  = $data['path'].'/'.$data['images'];
    
    $disk  =  Storage::exists($data['images']);
    return $disk ;
    if($disk == TRUE){
      $file_delete =  unlink(storage_path('/app/'.$data['images']));
      return $file_delete;
    }else{
      return $disk ;
    }
  }
}

?>