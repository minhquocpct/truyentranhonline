<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trang extends Model
{
    //
    protected $table = "trang";
    public function chap()
    {
    	return $this-> belongsTo('App\Chap', 'idChap', 'id');
    }
}
