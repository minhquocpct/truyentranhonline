 @extends('admin.layout.index')

 @section('content')
       <!-- Page Content -->
               <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Slide
                            <small>{{$slide->Ten}}</small>
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
                        <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Tên</label>
                                <input class="form-control" name="Ten" placeholder="Nhập tên slide" value="{{$slide->Ten}}" />
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="NoiDung" id="demo" class="ckeditor" rows="5">
                                    {{$slide->NoiDung}}
                                </textarea>
                            </div>
                                <div class="form-group">
                                <label>Truyện</label>
                                <select class="form-control" name="Truyen">
                                    @foreach($truyen as $t)
                                    
                                    <option 
                                    @if($slide->slide->id==$t->id)
                                    {{"selected"}}
                                    @endif


                                    value="{{$t->id}}">{{$t->TieuDe}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ảnh slide</label>
                                <p>
                                    <img width="400" src="{{$slide->Hinh}}">
                                </p>
                                <input type="file" name="Hinh">
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
  @endsection