<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPurchasing extends Model
{
    protected $table = 'trf_detail_barang_purchasing';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function detailpurchasing(){
        return $this->hasMany('App\Purchasing' , 'id' , 'id_purchasing');
      }


}
