    @extends('layout.index')

    @section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-9">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>{{$truyen->TieuDe}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a>Admin</a>
                </p>

                <!-- Preview Image -->
                <img width="350px" class="img-responsive" src="{{$truyen->Hinh}}" alt="">
                <br>
                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Updated at {{$truyen->updated_at}}</p>
                <hr>
                <h3><b>Nội dung truyện</b></h3>
                <!-- Post Content -->
                <p class="lead">{!!$truyen->NoiDung!!}</p>

                <hr>
                <h3><b>Danh sách chap</b></h3>
                @if($chap->count() == 0)
                <h3>Truyện chưa được upload chap</h3>
                @endif
                @foreach($chap as $c)
                    <div class="row-item row">
                        
                        
                            <a href="chap/{{$c->id}}"><h3>{{$c->TieuDe}}</h3></a>
                            <h4>Ngày updated: {{$c->updated_at}}</h4>
                            
                            <a class="btn btn-primary" href="chap/{{$c->id}}">Đọc<span class="glyphicon glyphicon-chevron-right"></span></a>
                        
                        <div class="break"></div>
                    </div>
                @endforeach
                {{$chap->links()}}
                <br>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                @if(Auth::user())
                <div class="well">
                    @if(session('thongbao'))
                    {{session('thongbao')}}
                    @endif
                    <h4>Viết bình luận<span class="glyphicon glyphicon-pencil"></span></h4>
                    <form action="comment/{{$truyen->id}}" role="form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <textarea name="NoiDung" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </form>
                </div>
                @endif
                <h4>Bình luận</h4>
                <hr>
                <!-- Posted Comments -->
                
                <!-- Comment -->
                @foreach($truyen->comment as $cm)
                <div class="media">
                    <a class="pull-left" href="#">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$cm->user->name}}
                            <small>{{$cm->updated_at}}</small>
                        </h4>
                        {{$cm->NoiDung}}
                    </div>
                </div>
                @endforeach
                <!-- Comment -->

                </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Truyện liên quan</b></div> 
                    <div class="panel-body">
                        @foreach($truyenlienquan as $tlq)
                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="truyen/{{$tlq->id}}">
                                    <img width="300px" class="img-responsive" src="{{$tlq->Hinh}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="truyen/{{$tlq->id}}"><b>{{$tlq->TieuDe}}</b></a>

                            </div>
                            
                            <div class="break"></div>
                        </div>
                        @endforeach
                        <!-- end item -->
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Truyện nổi bật</b></div>
                    @foreach($truyennoibat as $tnb)
                    <div class="panel-body">

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="truyen/{{$tnb->id}}">
                                    <img width="300px" class="img-responsive" src="{{$tnb->Hinh}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="truyen/{{$tnb->id}}"><b>{{$tnb->TieuDe}}</b></a>
                            </div>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->
                    </div>
                    @endforeach
                </div>
                
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->

    @endsection