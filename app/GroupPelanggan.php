<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPelanggan extends Model
{
    protected $table = 'mst_group_pelanggan';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
