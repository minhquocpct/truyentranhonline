 @extends('admin.layout.index')

 @section('content')
       <!-- Page Content -->
        <div id="page-wrapper">
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Chap
                            <small>Sửa</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                      
                     
                        <form action="admin/chap/sua/{{$chap->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Tên chap</label>
                                <input value="{{$chap->TieuDe}}" class="form-control" name="TieuDe" placeholder="Nhập tên chap" />
                            </div>
                            <div class="form-group">
                                <label>Thứ tự</label>
                                <input value="{{$chap->ThuTu}}" class="form-control" name="ThuTu" placeholder="Nhập thứ tự chap" />
                            </div>
                    

                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>


                        </form>
                        
                    </div>
                    <div class="col-lg-12">
                        <h1 class="page-header">Trang
                            <small>Danh sách</small>
                        </h1>
                    </div>
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                
                                <th>Thứ tự</th>
                                <th>Hinh</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chap->chap as $t)
                            <tr class="odd gradeX" align="center">
                                <td>{{$t->ThuTu}}</td>
                                <td>
                                    <div><img width="100px" src="{{$t->link}}"></div>
                                </td>
                                
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/trang/xoa/{{$t->id}}/{{$chap->id}}">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/trang/them/{{$chap->id}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <h3>Thêm trang cho truyện</h3>
                                <div class="form-group">
                                
                                <input multiple type="file" name="Hinh[]">
                                </div>
                            </div>
                    

                            <button type="submit" class="btn btn-default">Thêm Trang</button>
                            

                            
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
  @endsection
