<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chap extends Model
{
    protected $table = "chap";
    public function truyen()
    {
    	return $this-> belongsTo('App\Truyen', 'idTruyen', 'id');
    }
    public function chap(){
        return $this->hasMany('App\Trang','idChap','id');
    }
}
