<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Truyen;
use App\TheLoai;
use App\Comment;
use App\Chap;
use App\Trang;
use GuzzleHttp\Client as GuzzleClient;
class ImgurService
{    
        const END_POINT = 'https://api.imgur.com/3/image';

        public static function uploadImage($imagePath, $id)
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


class TruyenController extends Controller
{
    public function getDanhSach(){
    	$truyen = Truyen::all();
    	return view('admin.truyen.danhsach', ['truyen'=>$truyen]);
    }
    public function getSua($id){
    	$truyen = Truyen::find($id);
    	$theloai=TheLoai::all();
    	return view('admin.truyen.sua',['truyen'=>$truyen,'theloai'=>$theloai]);
    	
    }
    public function postSua(Request $request, $id){
		$truyen = Truyen::find($id);
		$this->validate($request,[
    		'TieuDe'=>'required|min:3|max:100',
    		'TomTat'=>'required',
    		'NoiDung'=>'required'
    	],[

    		'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
    		'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
    		'TieuDe.max'=>'Tiêu đề tối đa 100 kí tự',
    		//'TieuDe.unique'=>'Tiêu đề đã tồn tại',
    		'TomTat.required'=>'Bạn chưa nhập tóm tắt',
    		'NoiDung.required'=>'Bạn chưa nhập nội dung',
    	]);
    	$truyen->TieuDe= $request->TieuDe;
    	$truyen->TieuDeKhongDau = changeTitle($request->TieuDe);
    	$truyen->idTheLoai = $request->TheLoai;
    	$truyen->TomTat = $request->TomTat;
    	$truyen->NoiDung = $request->NoiDung;
        $truyen->NoiBat =$request->NoiBat;

    	if($request->hasFile('Hinh')){
    		$file = $request->file('Hinh');
    		$duoi = $file->getClientOriginalExtension();
    		if($duoi !='jpg'&& $duoi!='png'){
    			return redirect("admin/truyen/them")->with('loi','Bạn chỉ được chọn file có đuôi jpg và png');
    		}
            $imageUrl = ImgurService::uploadImage($file->getRealPath(),$id);
            $truyen->Hinh = $imageUrl;
    	}

    $truyen->save();
    return redirect('admin/truyen/sua/'.$id)->with('thongbao','Sửa thành công');

    }

    public function getThem(){
    	$theloai=TheLoai::all();
    	return view('admin.truyen.them',['theloai'=>$theloai]);
    }
	public function postThem(Request $request){
    	$this->validate($request,[
    		'TieuDe'=>'required|min:3|max:100|unique:Truyen,TieuDe',
    		'TomTat'=>'required',
    		'NoiDung'=>'required'
    	],[

    		'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
    		'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
    		'TieuDe.max'=>'Tiêu đề tối đa 100 kí tự',
    		'TieuDe.unique'=>'Tiêu đề đã tồn tại',
    		'TomTat.required'=>'Bạn chưa nhập tóm tắt',
    		'NoiDung.required'=>'Bạn chưa nhập nội dung',
    	]);

    	$truyen = new Truyen;
    	$truyen->TieuDe= $request->TieuDe;
    	$truyen->TieuDeKhongDau = changeTitle($request->TieuDe);
    	$truyen->idTheLoai = $request->TheLoai;
    	$truyen->TomTat = $request->TomTat;
    	$truyen->NoiDung = $request->NoiDung;
        $truyen->NoiBat =$request->NoiBat;
    	$truyen->SoLuotXem=0;
        $id = $request->TheLoai;
    	if($request->hasFile('Hinh')){
    		$file = $request->file('Hinh');
    		$duoi = $file->getClientOriginalExtension();
    		if($duoi !='jpg'&& $duoi!='png'){
    			return redirect("admin/truyen/them")->with('loi','Bạn chỉ được chọn file có đuôi jpg và png');
    		}
    		$imageUrl = ImgurService::uploadImage($file->getRealPath(),$id);
            $truyen->Hinh = $imageUrl;
    	}
    	else
    	{
    		$truyen->Hinh="";
    	}

    $truyen->save();
    return redirect("admin/truyen/them")->with('thongbao','Thêm truyện thành công');
   	}
    public function getXoa($id){
    	$truyen = Truyen::find($id);
        //fix bằng cách thêm if(empty())
        // $chap = Chap::Where('idTruyen',$id);
        // $t= $chap->id;
        // $trang = Trang::Where('idChap',$t);
        // $trang->delete(); 
        // $chap->delete();
    	$truyen ->delete();
    	return redirect('admin/truyen/danhsach')->with('thongbao','Xóa thành công');
    }
}
