<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Truyen;
use App\TheLoai;
use App\Chap;
use App\Comment;
use App\Trang;
use App\User;
class ListController extends Controller
{
    public function list(){
    	return response()->json([
    		'success'=>true,
    		'list'=> Truyen::all(),
    	]);
    }
    public function category(){
    	return response()->json([
    		'success'=>true,
    		'category'=> TheLoai::all(),
    	]);
    }
    public function search(Request $request){
    	if ($request->idcategory!='') {
    		$truyen = Truyen::where('idTheLoai',$request->idcategory)->get();
    		return response()->json([
    			'success'=>true,
    			'list'=> $truyen,
    		]);
    	}
    	elseif ($request->keyword!='') {
    		$truyen = Truyen::where('TieuDe','like',"%$request->keyword%")->get();
    		if (count($truyen)>0)
    		{
    			return response()->json([
    				'success'=>true,
    				'list'=> $truyen,
    			]);
    			
    		}
    		else
    		{
    			return response()->json([
    				'success'=>false,
    				'nonexist'=>true,
    			]);
    		}
    			
    	}
    	else
    	{
    		return response()->json([
    			'success'=>false,
    			'message'=>'false',
    		]);
    	}
    }
     public function manga(Request $request){
     		$truyen = Truyen::find($request->idmanga);
     		$chap = Chap::where('idTruyen',$request->idmanga)->orderBy('ThuTu','DESC')->get();
     		$comment = Comment::where('idTruyen',$request->idmanga)->orderBy('created_at','DESC')->get();
     		foreach ($comment  as $comment2)
     			# code...
     		{
    			$comment2->user;
			}
     		return response()->json([
    				'success'=>true,
    				'manga'=> $truyen,
    				'listchap'=> $chap,
    				'comment'=> $comment,
    		]);
     }
     public function comment(Request $request){
     	$comment = new Comment;
     	$comment->idUser= $request->idUser;
     	$comment->idTruyen=$request->idManga;
     	$comment->NoiDung=$request->comment;
     	$comment->save();
        return response()->json([
                    'success'=>true,
                    'message'=> 'comment success',
        ]);
     }
     
     public function chap(Request $request){
     if ($request->idChap=='') {
     
        if ($request->NumberNextChap!='') {
            $chapnext = Chap::where('idTruyen',$request->idManga)->where('ThuTu',$request->NumberNextChap)->first();
            if ($chapnext!='') {
                $pagenext = Trang::where('idChap',$chapnext->id)->orderBy('ThuTu','asc')->get();
                  foreach ($pagenext  as $p)
                {
                    $r=$p->chap;
                }
              
                return response()->json([
                    'success'=>true,
                    'chap'=>$r,
                    'listpage'=> $pagenext,
                ]);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'nextnonexist'=>true,
                ]);
            }
        }
        elseif ($request->NumberPreChap!='') {
            $chappre = Chap::where('idTruyen',$request->idManga)->where('ThuTu',$request->NumberPreChap)->first();
             if ($chappre!='') {
                $pagepre = Trang::where('idChap',$chappre->id)->orderBy('ThuTu','asc')->get();
                foreach ($pagepre  as $p)
            {
                $r=$p->chap;
            }
                return response()->json([
                    'success'=>true,
                    'chap'=>$r,
                    'listpage'=> $pagepre,
                ]);
            }
            else{

                return response()->json([
                    'success'=>false,
                    'prenonexist'=>true,
                ]);
            }
         }
     }
        else{
            $page = Trang::where('idChap',$request->idChap)->orderBy('ThuTu','asc')->get();
            foreach ($page  as $p)
                # code...
            {
                $r=$p->chap;
            }
        return response()->json([
                    'success'=>true,
                    'chap'=>$r,
                    'listpage'=> $page,
                ]);
            }
     }
     public function check(Request $request){
        if ($request->NumberNextChap!='') {
            $chapnext = Chap::where('idTruyen',$request->idManga)->where('ThuTu',$request->NumberNextChap)->first();
            if ($chapnext!='') {
                return response()->json([
                    'success'=>true,
                    'nextnonexist'=>false,
                ]);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'nextnonexist'=>true,
                ]);
            }
        }
        elseif ($request->NumberPreChap!='') {
            $chappre = Chap::where('idTruyen',$request->idManga)->where('ThuTu',$request->NumberPreChap)->first();
             if ($chappre!='') {
                $pagepre = Trang::where('idChap',$chappre->id)->orderBy('ThuTu','asc')->get();
                return response()->json([
                    'success'=>true,
                    'prenonexist'=>false,
                ]);
            }
            else{

                return response()->json([
                    'success'=>false,
                    'prenonexist'=>true,
                ]);
            }
         }
     }
}
