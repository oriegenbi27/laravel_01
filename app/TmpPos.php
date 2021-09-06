<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpPos extends Model
{
  protected $table = 'mst_tmp_pos';
  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  public function joinProduk(){
     return $this->hasMany('App\Produk' , 'id' ,'id_produk');
   }
}

