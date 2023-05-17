<div class="col-md-3 ">
                <ul class="list-group" id="menu">
                    <li class="list-group-item menu1 active">Danh sách</a>

                    </li>
                    <li href="" class="list-group-item menu1">
                        <a href="danhsach">Toàn bộ</a>
                    </li>
                    <li class="list-group-item menu1 active">
                    	Thể loại
                    </li>
                    @foreach($theloai as $tl)
                    <li href="" class="list-group-item menu1">
                    	<a href="theloai/{{$tl->id}}">{{$tl->Ten}}</a>
                    </li>
                    @endforeach
                </ul>
                <ul class="list-group" id="menu">
                    
                </ul>
            </div>