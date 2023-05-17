<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = "comment";

    public function truyen()
    {
    	return $this->belongsTo('App\Truyen','idTruyen', 'id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User', 'idUser', 'id');
    }
}
