<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Truyen;
use App\Chap;
use App\Trang;

class ChapController extends Controller
{
	function __construct(){

	}
    function getThem($id){
    	$truyen= Truyen::find($id);
    	return view('admin.chap.them',['truyen'=>$truyen]);
    }
    function postThem($id, Request $request){
    	$this->validate($request,[
            'TieuDe'=>'required',
            'ThuTu'=>'required',
            
        ],[
            'TieuDe.required'=>'Bạn chưa nhập tên chap',
            'ThuTu.required'=>'Bạn chưa nhập thứ tự chap',
            
        ]);
        $chap = new Chap;
        $truyen= Truyen::find($id);
        $chap->TieuDe = $request->TieuDe;
        $chap->ThuTu = $request->ThuTu;
        $chap->idTruyen = $truyen->id;
        $chap->save();
        return view('admin.chap.them',['truyen'=>$truyen]);

    }
        function getSua($id){
    	$chap = Chap::find($id);
    	return view('admin.chap.sua',['chap'=>$chap]);
    }
    	function postSua(Request $request,$id){
    		$this->validate($request,[
            'TieuDe'=>'required',
            'ThuTu'=>'required',
            
        ],[
            'TieuDe.required'=>'Bạn chưa nhập tên chap',
            'ThuTu.required'=>'Bạn chưa nhập thứ tự chap',
            
        ]);
    		$chap = Chap::find($id);
    		$chap->TieuDe = $request->TieuDe;
            $chap->ThuTu = $request->ThuTu;
    		$chap->save();
    		return redirect('admin/chap/sua/'.$id)->with('thongbao','Sửa chap thành công');
    	}
        public function getXoa($id,$idTruyen){
    	$chap = Chap::find($id);
        $trang = Trang::Where('idChap',$id);
        if(empty ($trang)){
            $chap->delete();
        }
        else
        {
    	    $trang->delete();
            $chap ->delete();
        }
    	return redirect('admin/truyen/sua/'.$idTruyen)->with('thongbao','Xóa chap thành công');
    }
}
