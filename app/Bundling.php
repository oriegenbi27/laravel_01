<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundling extends Model
{
    protected $table = 'mst_bundling';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function gratis(){
        return $this->hasMany(Produk::class, 'id','fitem');
      }
    public function item(){
        return $this->hasMany(Produk::class, 'id','item');
      }
    


}
