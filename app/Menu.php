<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'mst_menu';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    
    public function menu(){
      return $this->hasMany(Jabatan::class);
    }

    
    public function level(){
      return $this->belongsTo(Level::class);
    }
}
