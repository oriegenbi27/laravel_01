<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosDetail extends Model
{
    protected $table = 'mst_pos_detail';
    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function detailorder(){
        return $this->hasMany(DetailOrder::class,'id_order', 'id');
      }
}
