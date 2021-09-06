<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SumberSales extends Model
{
    protected $table = 'mst_sumber_sales';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
