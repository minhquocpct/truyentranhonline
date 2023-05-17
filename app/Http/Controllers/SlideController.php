<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Truyen;
use App\TheLoai;
use App\Comment;
use App\Slide;
use GuzzleHttp\Client as GuzzleClient;
class ImgurService
{    
        const END_POINT = 'https://api.imgur.com/3/image';

        public static function uploadImage($imagePath)
        {
                $client = new GuzzleClient();
                $request = $client->request(
                    'POST',
                    ImgurService::END_POINT,
                    [
                        'headers' => [
                            'Authorization' => "Client-ID ".env('CLIENT_ID'), // post as anonymous
                        ],
                        'form_params' => [
                            'image' => file_get_contents($imagePath)
                        ]
                    ]
                );
                $response = (string) $request->getBody();
                $jsonResponse = json_decode($response);
                return $jsonResponse->data->link; // return url of image            
            
        }


}

class SlideController extends Controller
{
    public function getDanhSach(){
        $slide = Slide::all();
        return view('admin.slide.danhsach',['slide'=>$slide]);
    	
    } 
    public function getSua($id){
        $truyen = Truyen::all();
        $slide = Slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide,'truyen'=>$truyen]);
    	
    }
    public function postSua(Request $request, $id){
		$this->validate($request,[
            'Ten'=>'required',
            'NoiDung'=>'required',
        ],[
            'Ten.required'=>'Bạn chưa nhập tên side',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]);
        $slide = Slide::find($id);
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->idTruyen= $request->Truyen;
        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi !='jpg'&& $duoi!='png'){
                return redirect("admin/slide/them")->with('loi','Bạn chỉ được chọn file có đuôi jpg và png');
            }
            $imageUrl = ImgurService::uploadImage($file->getRealPath());
            $slide->Hinh = $imageUrl;
        }
        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','
        Sửa thành công');
    }

    public function getThem(){
        $truyen = Truyen::all();
        return view('admin.slide.them',['truyen'=>$truyen]);
    }
	public function postThem(Request $request){
    	$this->validate($request,[
            'Ten'=>'required',
            'NoiDung'=>'required',
        ],[
            'Ten.required'=>'Bạn chưa nhập tên side',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]);
        $slide = new Slide;
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->idTruyen= $request->Truyen;
        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi !='jpg'&& $duoi!='png'){
                return redirect("admin/slide/them")->with('loi','Bạn chỉ được chọn file có đuôi jpg và png');
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;
            while (file_exists("upload/slide/".$Hinh)) {
                $Hinh = Str::random(4)."_".$name;
            }
            //echo $Hinh;
            $file->move("upload/slide",$Hinh);
            $slide->Hinh =$Hinh;
        }
        else
        {
            $truyen->Hinh="";
        }
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao','Thêm thành công');
   	}
    public function getXoa($id){
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/danhsach')->with('thongbao','Xóa thành công');
    }
}
