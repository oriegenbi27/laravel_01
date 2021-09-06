<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    protected $table = 'mst_detail_produk';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function detailproduk(){
        return $this->hasMany('App\Produk' , 'id' , 'id_produk');
      }



}
