@extends('layout.index')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            @include('layout.menu')

            <div class="col-md-9 ">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h4><b>Toàn bộ</b></h4>
                    </div>
                    @foreach($truyen as $t)
                    <div class="row-item row">
                        <div class="col-md-3">
 
                            <a href="truyen/{{$t->id}}">
                                <br>
                                <img width="200px" height="200px" class="img-responsive" src="{{$t->Hinh}}" alt="">
                            </a>
                        </div>

                        <div class="col-md-9">
                            <h3>{{$t->TieuDe}}</h3>
                            <p>{!!$t->TomTat!!}</p>
                            <a class="btn btn-primary" href="truyen/{{$t->id}}">Đọc Truyện<span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                        <div class="break"></div>
                    </div>
                    @endforeach
                    {{$truyen->links()}}
                </div>
            </div> 

        </div>

    </div>
    <!-- end Page Content -->
@endsection