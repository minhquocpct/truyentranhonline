 @extends('admin.layout.index')

 @section('content')
       <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Truyện
                            <small>{{$truyen->TieuDe}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                          @if(count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <form action="admin/truyen/sua/{{$truyen->id}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Thể loại</label>
                                <select class="form-control" name="TheLoai">
                                    @foreach($theloai as $tt)
                                    
                                    <option 
                                    @if($truyen->theloai->id==$tt->id)
                                    {{"selected"}}
                                    @endif


                                    value="{{$tt->id}}">{{$tt->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$truyen->TieuDe}}" />
                            </div>
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea name="TomTat" id="demo" class="form-control" rows="3" value="">{{$truyen->TomTat}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="NoiDung" id="demo" class="ckeditor" rows="5" value="">{{$truyen->NoiDung}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Ảnh bìa truyện</label>
                                <p><img width="100px" src="{{$truyen->Hinh}}"></p>
                                <input type="file" name="Hinh">
                            </div>
                            <div class="form-group">
                                <label>Nổi bật</label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="0" @if($truyen->NoiBat==0)
                                    {{'checked'}}
                                    @endif
                                    checked="" type="radio">Không
                                </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="1" @if($truyen->NoiBat==1)
                                    {{'checked'}}
                                    @endif
                                    type="radio">Có
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Chap
                            <small>Danh sách</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Thứ tự</th>
                                <th>Tên Chap</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($truyen->truyen as $c)
                            <tr class="odd gradeX" align="center">
                                <td>{{$c->id}}</td>
                                <td>{{$c->ThuTu}}</td>
                                <td>
                                    {{$c->TieuDe}}
                                </td>
                                
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/chap/sua/{{$c->id}}">Edit</a></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/chap/xoa/{{$c->id}}/{{$truyen->id}}">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="admin/chap/them/{{$truyen->id}}"><button type="button" class="btn btn-default">Thêm chap</button></a>
                    
                </div>
                 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bình luận
                            <small>Danh sách</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($truyen->comment as $cmt)
                            <tr class="odd gradeX" align="center">
                                <td>{{$cmt->id}}</td>
                                <td>
                                    {{$cmt->user->name}}
                                </td>
                                <td>{{$cmt->NoiDung}}</td>
                                <td>{{$cmt->created_at}}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$cmt->id}}/{{$truyen->id}}"> Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

  @endsection