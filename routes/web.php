<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;
use App\Truyen;
use App\Comment;
use App\Slide;
use App\User;
use App\Chap;
use App\Trang;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/trangchu','PagesController@trangchu');
//Test

// Route::get('thu', function(){
// 		$theloai = TheLoai::find(1);
// 	foreach($theloai->truyen as $truyen)
// 	{
// 	 	echo $truyen->TieuDe."<br>";
// 	 }
// });
/*
Route::get('test', function(){
	return view('admin.theloai.them');
});*/
Route::get('admin/dangnhap','UserController@getDangnhapAdmin');
Route::post('admin/dangnhap','UserController@postDangnhapAdmin');
Route::get('admin/logout','UserController@getDangXuatAdmin');
Route::get('admin',function(){
	return redirect('admin/theloai/danhsach');
});
Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	Route::group(['prefix'=>'theloai'],function(){
		
		Route::get('danhsach','TheLoaiController@getDanhSach');

		Route::get('sua/{id}','TheLoaiController@getSua');
		Route::post('sua/{id}','TheLoaiController@postSua');

		Route::get('them','TheLoaiController@getThem');
		Route::post('them', 'TheLoaiController@postThem');
		Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	});
		Route::group(['prefix'=>'truyen'],function(){
			Route::get('danhsach','TruyenController@getDanhSach');
			Route::get('them','TruyenController@getThem');
			Route::post('them','TruyenController@postThem');
			Route::get('sua/{id}','TruyenController@getSua');
			Route::post('sua/{id}','TruyenController@postSua');
			Route::get('xoa/{id}','TruyenController@getXoa');

	});
		Route::group(['prefix'=>'chap'],function(){
				Route::get('them/{id}','ChapController@getThem');
				Route::post('them/{id}','ChapController@postThem');
				Route::get('sua/{id}','ChapController@getSua');
				Route::post('sua/{id}','ChapController@postSua');
				Route::get('xoa/{id}/{idTruyen}','ChapController@getXoa');

			});
		Route::group(['prefix'=>'trang'],function(){
				Route::post('them/{id}','TrangController@postThem');
				Route::get('xoa/{id}/{idChap}','TrangController@getXoa');
				
			});
		
		Route::group(['prefix'=>'comment'],function(){
			Route::get('xoa/{id}/{idTruyen}','CommentController@getXoa');

	});

			Route::group(['prefix'=>'slide'],function(){
			Route::get('danhsach','SlideController@getDanhSach');
			Route::get('them','SlideController@getThem');
			Route::post('them','SlideController@postThem');
			Route::get('sua/{id}','SlideController@getSua');
			Route::post('sua/{id}','SlideController@postSua');
			Route::get('xoa/{id}','SlideController@getXoa');

	});
	Route::group(['prefix'=>'user'],function(){
			Route::get('danhsach','UserController@getDanhSach');
			Route::get('them','UserController@getThem');
			Route::post('them','UserController@postThem');
			Route::get('sua/{id}','UserController@getSua');
			Route::post('sua/{id}','UserController@postSua');
			Route::get('xoa/{id}','UserController@getXoa');

	});
});

Route::get('/','PagesController@trangchu');
// Route::get('/',function(){
// 	return redirect('admin/theloai/danhsach');
// });
Route::get('lienhe','PagesController@lienhe');
Route::get('gioithieu','PagesController@gioithieu');
Route::get('theloai/{id}','PagesController@theloai');
Route::get('truyen/{id}','PagesController@truyen');
Route::get('dangnhap','PagesController@getDangnhap');
Route::post('dangnhap','PagesController@postDangnhap');
Route::get('dangxuat','PagesController@getDangxuat');
Route::post('comment/{id}','CommentController@postComment');
Route::get('nguoidung','PagesController@getNguoidung');
Route::post('nguoidung','PagesController@postNguoidung');
Route::get('dangky','PagesController@getDangky');
Route::post('dangky','PagesController@postDangky');
Route::post('timkiem','PagesController@timkiem');
Route::get('danhsach','PagesController@danhsach');
Route::get('chap/{id}','PagesController@chap');