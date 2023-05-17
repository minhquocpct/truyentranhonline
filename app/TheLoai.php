<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table = "theloai";
    public function truyen()
    {
    	return $this-> hasMany('App\Truyen','idTheLoai', 'id');
    }

}