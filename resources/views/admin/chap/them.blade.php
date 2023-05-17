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
                            <small>Thêm</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                      
                     
                        <form action="admin/chap/them/{{$truyen->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Tên chap</label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập tên chap" />
                            </div>
                    <div class="form-group">
                                <label>Thứ tự chap</label>
                                <input class="form-control" name="ThuTu" placeholder="Nhập thứ tự chap" />
                            </div>

                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
  @endsection
