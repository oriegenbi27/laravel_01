<?php

namespace App\Helpers;

/**
 * General
 *
 * PHP version 7
 *
 * @category General
 * @package  General
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class General
{
	/**
	 * Generate multilevel select input
	 *
	 * @param string $name    name
	 * @param array  $array   array data
	 * @param array  $options additional option
	 *
	 * @return string
	 */

  public function log_finance($data){
    
    $parameter                        = new Log_finance();
    $parameter->code                  = $data['code'];
    $parameter->id_user               = $data['id_user'];
    $parameter->id_owner              = $data['id_owner'];
    $parameter->amount                = $data['amount'];
    $parameter->id_differential       = $data['id_differential'];
    $parameter->no_bukti              = $data['no_bukti'];
    $parameter->nama_perkiraan        = $data['nama_perkiraan'];
    $parameter->nama_pendapatan       = $data['nama_pendapatan'];
    $parameter->debit                 = $data['debit'];
    $parameter->kredit                = $data['kredit'];
    $parameter->menu                  = $data['menu'];
    $parameter->action                = $data['action'];
    $parameter->save();

    return $parameter;

  }

}