<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Truyen;
use App\TheLoai;
use App\Comment;
use App\Slide;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDanhSach(){
        $user =User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    }
    public function getSua($id){
        $user = User::find($id);
        return view('admin.user.sua',['user'=>$user]);
    	
    }
    public function postSua(Request $request, $id){
		$this->validate($request,[
                'name'=>'required|min:3',
        ],[
                'name.required' =>'Bạn chưa nhập tên người dùng',
                'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
        ]);
        $user = User::find($id);
        
        $user ->name = $request->name;
        
        $user->quyen = $request->quyen;
        
        if(isset($request->changePassword )){
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
        return redirect('admin/user/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
    }

    public function getThem(){
        return view('admin.user.them');
    }
	public function postThem(Request $request){
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
                'email.unique'=>'Bạn chưa nhập trùng email',
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
        $user->quyen = $request->quyen;
        $user->save();

        return redirect('admin/user/them')->with('thongbao','Thêm thành công');

   	}
    public function getXoa($id){
        $user = User::find($id);
        $comment = Comment::where('idUser',$id);
        $comment->delete();
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao','Xóa tài khoản thành công');
    }
    public function getDangnhapAdmin(){
        return view('admin.login');
    }
    public function postDangnhapAdmin(Request $request){
        $this ->validate($request,[
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập password',
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('admin/theloai/danhsach');
        }
        else
        {
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getDangXuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
