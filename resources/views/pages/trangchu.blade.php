    @extends('layout.index')
    @section('content')
    <!-- Page Content -->
    <div class="container">
    	@include('layout.slide')
        <div class="space20"></div>
        <div class="row main-left">
            @include('layout.menu')

            <div class="col-md-9">
	            <div class="panel panel-default">            
	            	<div class="panel-heading" style="background-color:#337AB7; color:white;" >
	            		<h2 style="margin-top:0px; margin-bottom:0px;">Truyện nổi bật</h2>
	            	</div>

	            	<div class="panel-body">
	            		@foreach($theloai as $tl)
	            		<!-- item -->
					    <div class="row-item row">
		                	<h3>
		                		<a href="theloai/{{$tl->id}}">{{$tl->Ten}}</a>
		                	</h3>
		                	<?php
			                    	$data = $tl->truyen->where('NoiBat',1)->sortByDesc('created_at')->take(5);
			                    	$truyen1 = $data->shift();
			                    ?>
		                	<div class="col-md-8 border-right">
		                		<div class="col-md-5">
			                        <a href="truyen/{{$truyen1['id']}}">
			                            <img width="300px" class="img-responsive" src="{{$truyen1['Hinh']}}" alt="">
			                        </a>
			                    </div>
			                    
			                    <div class="col-md-7">
			                        <h3>{{$truyen1['TieuDe']}}</h3>
			                        <p>{!!$truyen1['TomTat']!!}</p>
			                        <a class="btn btn-primary" href="truyen/{{$truyen1['id']}}">Đọc truyện<span class="glyphicon glyphicon-chevron-right"></span></a>
								</div>

		                	</div>
		                    <div><h4>Nổi bật cùng thể loại</h4></div>
		                	@foreach($data->all() as $truyen)

							<div class="col-md-4">

								<div class="col-md-5">
			                        <a href="truyen/{{$truyen['id']}}">
			                            <img width="100px" class="img-responsive" src="{{$truyen['Hinh']}}" alt="">

			                        </a>
			                        <br>
			                    </div>
								<a href="truyen/{{$truyen['id']}}">
									<h4>
										{{$truyen['TieuDe']}}

									</h4>
								</a>
							</div>
							@endforeach
							
							<div class="break"></div>
		                </div>
		                <!-- end item -->
		                @endforeach
					</div>
	            </div>
        	</div>
        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->
    @endsection