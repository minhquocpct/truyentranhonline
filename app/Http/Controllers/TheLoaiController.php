<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach', ['theloai'=>$theloai]);

    }
    public function getSua($id){
    	$theloai= TheLoai::find($id);
    	return view('admin.theloai.sua',['theloai'=>$theloai]);	
    }
    public function postSua(Request $request, $id){
		$theloai = TheLoai::find($id);
		$this->validate($request,
			[
				'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'
			],[
				'Ten.required' => 'Bạn chưa nhập tên thể loại',
				'Ten.unique'=>'Tên thể loại đã tồn tại',
				'Ten.min'=>'Ten thể loại phải có độ dài từ 3 cho đến 100 kí tự',
    			'Ten.max'=>'Ten thể loại phải có độ dài từ 3 cho đến 100 kí tự',

			]);    
			$theloai->Ten = $request->Ten;	 
			$theloai->TenKhongDau =changeTitle($request->Ten);
			$theloai->save();

			return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công');	
    }

    public function getThem(){
    	return view('admin.theloai.them');
    }
    public function postThem(Request $request){
    	$this->validate($request,
    		[
    			'Ten'=> 'required|unique:TheLoai,Ten|min:3|max:100'
    		],
    		[
    			'Ten.required'=>'Bạn chưa nhập tên thể loại',
    			'Ten.min'=>'Ten thể loại phải có độ dài từ 3 cho đến 100 kí tự',
    			'Ten.max'=>'Ten thể loại phải có độ dài từ 3 cho đến 100 kí tự',
    			'Ten.unique'=>'Tên thể loại đã tồn tại',

    		]);
    	$theloai = new TheLoai;
    	$theloai->Ten = $request ->Ten;
    	$theloai->TenKhongDau =changeTitle($request->Ten);
    	//echo changeTitle($request->Ten);
    	$theloai->save();
    	return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');

    }
    public function getXoa($id){
    	$theloai= TheLoai::find($id);
    	$theloai->delete();

    	return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
