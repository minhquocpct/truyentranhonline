<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\Truyen;
use App\User;
use App\Chap;
use App\Trang;
use Illuminate\Support\Facades\Auth;
class PagesController extends Controller
{
    //
	function __construct(){
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai',$theloai);
		view()->share('slide',$slide);
        if(Auth::check())
        {
            view()->share(Auth::user());
        }
	}

    function trangchu()
    {
    	return view('pages.trangchu');
    }
    function lienhe(){
    	return view('pages.lienhe');
    }
    function gioithieu(){
        return view('pages.gioithieu');
    }
    function theloai($id){
        $theloaitruyen = TheLoai::find($id);
        $truyen = Truyen::where('idTheLoai',$id)->orderBy('id','DESC')->paginate(4);
        return view('pages.theloai',['theloaitruyen'=>$theloaitruyen,'truyen'=>$truyen]);
    }
    function truyen($id){
        $truyen = Truyen::find($id);
        $chap = Chap::where('idTruyen',$id)->orderBy('ThuTu','DESC')->paginate(10);
        $truyennoibat = Truyen::where('NoiBat',1)->take(4)->get();
        $truyenlienquan = Truyen::where('idTheLoai',$truyen->idTheLoai)->take(4)->get();
        return view('pages.truyen',['truyen'=>$truyen,'truyennoibat'=>$truyennoibat,'truyenlienquan'=>$truyenlienquan,'chap'=>$chap]);
    }
    function getDangnhap(){
        return view('pages.dangnhap');
    }
    function postDangnhap(Request $request){
        $this ->validate($request,[
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập password',
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/');
        }
        else
        {
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    function getDangxuat()
    {
        Auth::logout();
        return redirect('/');
    }
    function getNguoidung(){
        return view('pages.nguoidung');
    }
    function postNguoidung(Request $request){
        $this->validate($request,[
                'name'=>'required|min:3',
        ],[
                'name.required' =>'Bạn chưa nhập tên người dùng',
                'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
        ]);
        $user = Auth::user();
        
        $user ->name = $request->name;
        
        //$user->quyen = $request->quyen;
        
        if(isset($request->changePassword)){
            $this->validate($request,[
                'password'=>'required|min:3|max:30',
                'passwordAgain'=>'required|same:password'
        ],[
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải có ít nhất 3 kí tự',
                'password.max'=>'Mật khẩu tối đa 30 kí tự',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
        ]);
            $user->password = bcrypt($request->password);

        }

        $user->save();
        return redirect('nguoidung')->with('thongbao','Bạn đã sửa thành công');
    }
    function getDangky(){
        return view('pages.dangky');
    }
    function postDangky(Request $request){
        $this->validate($request,[
                'name'=>'required|min:3',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:3|max:30',
                'passwordAgain'=>'required|same:password'
        ],[
                'name.required' =>'Bạn chưa nhập tên người dùng',
                'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
                'email.required'=>'Bạn chưa nhập email',
                'email.email'=>'Bạn chưa nhập đúng định dạng email',
                'email.unique'=>'Bạn nhập trùng email',
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải có ít nhất 3 kí tự',
                'password.max'=>'Mật khẩu tối đa 30 kí tự',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
        ]);
        $user = new User;
        $user ->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();

        return redirect('dangky')->with('thongbao','Đăng ký thành công');

    }
    function timkiem(Request $request){
        $tukhoa = $request->tukhoa;
        if ($tukhoa=="") {
            return redirect('/')->with('thongbao','Bạn chưa nhập từ khóa');
        }
        else
        {
        $truyen = Truyen::where('TieuDe','like',"%$tukhoa%")->take(30)->paginate(5);
        return view('pages.timkiem',['truyen'=>$truyen,'tukhoa'=>$tukhoa]);
    }
    }
    function danhsach(){
        $truyen = Truyen::where(null)->orderBy('id','DESC')->paginate(4);
    
        return view('pages.danhsach',['truyen'=>$truyen]);
    }
    function chap($id){
        $chap = Chap::find($id);
        $idTruyen=$chap->truyen->id;
        $trang = Trang::where('idChap',$id)->orderBy('ThuTu','asc')->get();
        $chaplist = Chap::where('idTruyen',$idTruyen)->orderBy('ThuTu','DESC')->get();
        $thutuchapnext = $chap->ThuTu+1; 
        $thutuchappre = $chap->ThuTu-1;
        $chapnext = Chap::where('idTruyen',$idTruyen)->where('ThuTu',$thutuchapnext)->first();
        $chappre = Chap::where('idTruyen',$idTruyen)->where('ThuTu',$thutuchappre)->first();    
        return view('pages.chap',['trang'=>$trang,'chap'=>$chap,'chapnext'=>$chapnext,'chappre'=>$chappre,'chaplist'=>$chaplist]);
    }
}
