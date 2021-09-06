<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchasing extends Model
{
    protected $table = 'trf_purchasing';

    public function detailpurchasing(){
        return $this->hasMany(DetailPurchasing::class,'id_purchasing', 'code');
      }

      public function owner(){
        return $this->hasOne(Setting::class,'id_owner', 'id_owner');
      }


      protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    public static function generateCode($owner,$code)
    {

      $dateCode = $code . '/' . date('ymd') . '/' .\General::integerToRoman(date('m')). '/' .\General::integerToRoman(date('d')). '/';

      $lastOrder = self::select([\DB::raw('MAX(trf_purchasing.code) AS last_code')])
        ->where('id_owner',$owner )
        ->where('code', 'like', $dateCode . '%')
        ->first();

      $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;

      $orderCode = $dateCode . '00001';
      if ($lastOrderCode) {
        $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
        $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);

        $orderCode = $dateCode . $nextOrderNumber;
      }

      // if (self::_isOrderCodeExists($orderCode)) {
      //   return generateOrderCode();
      // }

      return $orderCode;
    }

}
