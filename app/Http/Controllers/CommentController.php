<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Truyen;
use App\TheLoai;
use App\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function getXoa($id,$idTruyen){
    	$comment = Comment::find($id);
    	$comment ->delete();
    	return redirect('admin/truyen/sua/'.$idTruyen)->with('thongbao','Xóa comment thành công');
    }
    public function postComment($id, Request $request){
    	$idTruyen = $id;
    	$truyen = Truyen::find($id);
    	$comment = new Comment;
    	$comment->idTruyen = $idTruyen;
    	$comment->idUser = Auth::user()->id;
    	$comment->NoiDung = $request->NoiDung;
    	$comment->save();
    	return redirect("truyen/$id")->with('thongbao','Viết bình luận thành công');
    }
}
