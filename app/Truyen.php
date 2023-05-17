<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truyen extends Model
{
    //
    protected $table = "truyen";

    public function theloai()
    {
    	return $this-> belongsTo('App\TheLoai', 'idTheLoai', 'id');
    }
    public function comment(){
    	return $this->hasMany('App\Comment', 'idTruyen','id');
    }
    public function slide(){
    	return $this->hasMany('App\Slide', 'idTruyen','id');
    }
    public function truyen(){
        return $this->hasMany('App\Chap','idTruyen','id');
    }

}
