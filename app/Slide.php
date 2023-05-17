<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
    protected $table = "slide";
    public function slide()
    {
    	return $this->belongsTo('App\Truyen', 'idTruyen','id');
    }
}

