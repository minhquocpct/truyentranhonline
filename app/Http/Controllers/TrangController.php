<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chap;
use App\Trang;
use GuzzleHttp\Exception\GuzzleException;
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


class TrangController extends Controller
{
    public function postThem(Request $request, $id){
    	    $this->validate($request,[
    		
    		'Hinh'=>'required',
    		
    	],[

    		'Hinh.required'=>'Bạn chưa chọn hình',
    		
    	]);
    	$trangcuoi = Trang::where('idChap',$id)->orderBy('ThuTu','DESC')->take(1)->get();
    	foreach ($trangcuoi as $key) {
    		# code...
    		$x = $key->ThuTu;
    	}
    	if (empty($x)) {
    		$x=0;
    	}

    	$t=$x+1;
    	$files = $request->Hinh;
    	foreach ( $files as $file) {

    		$trang = new Trang;
    		$imageUrl = ImgurService::uploadImage($file->getRealPath(),$id);
    		$trang->link = $imageUrl;
    		$trang->idChap = $id;
    		$trang->ThuTu = $t;
    		$t=$t+1;
    		$trang->save();
    		# code...
    	}
    	return redirect('admin/chap/sua/'.$id)->with('thongbao','Thêm trang cho chap thành công');
    }
    public function getXoa($id, $idChap){
    	$trang = Trang::find($id);
    	$trang ->delete();
    	return redirect('admin/chap/sua/'.$idChap)->with('thongbao','Xóa thành công');
    }
}
