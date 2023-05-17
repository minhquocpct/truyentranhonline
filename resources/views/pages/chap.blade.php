@extends('layout.index')

@section('content')
<div style="margin:auto;width: 65%;" class="container">
        <div class="row">
            <!-- @include('layout.menu') -->

            <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        
                        <h4><a style="color: white " href="">Trang chủ</a> > <a style="color: white"  href="truyen/{{$chap->truyen->id}}"> {{$chap->truyen->TieuDe}}</a> > {{$chap->TieuDe}}</h4>
                    </div>
                    
                     <div style="margin-bottom: 15px;margin-top: 15px; width: 100%">
                  
                
                   
                @if(is_null($chapnext))
                <a style="float: right;width: 15%;" onclick="return alert('Đây là chap cuối')"><button style="width: 100%;" type="button" class="btn btn-default">></button></a>
                @else<a style="float: right;width: 15%;" href="chap/{{$chapnext->id}}">
                <button  style=" width: 100%;"  type="button" class="btn btn-default">></button></a>
                @endif
                @if(is_null($chappre))
                <a style="float: left;width: 15%;" onclick="return alert('Đây là chap đầu')"><button style="width: 100%;"  type="button" class="btn btn-default"><</button></a>
                @else<a style="float: left;width: 15%;" href="chap/{{$chappre->id}}">
                <button style="width: 100%;" type="button" class="btn btn-default"><</button></a>
                @endif
                 
                                
                              <select style="margin: auto;width: 68%"  class="form-control" onchange="location=this.value;">
                                    @foreach($chaplist as $l)              
                                    <option @if($chap->id==$l->id)
                                    {{"selected"}}
                                    @endif
                                    value="chap/{{$l->id}}">{{$l->TieuDe}}</option>
                                    @endforeach
                                </select>
           
                </div>

            <!-- <div class="col-md-9 "> -->
                <div class="panel panel-default">
                    
                    <br>
                    @if($trang->count()==0)
                    	<h3 style="text-align: center;">Chap này chưa được upload ảnh</h3>
                    @endif
                    @foreach($trang as $t)
                    
                      
                    	<img width="100%" style="margin-left: auto; margin-right: auto;display: block;" src="{{$t->link}}">
                        
                    
                    @endforeach
                    <br>
                </div>
            <!-- </div>  -->
                

                <div style=" width: 100%">
                  
                
                   
                @if(is_null($chapnext))
                <a style="float: right;width: 15%;" onclick="return alert('Đây là chap cuối')"><button style="width: 100%;" type="button" class="btn btn-default">></button></a>
                @else<a style="float: right;width: 15%;" href="chap/{{$chapnext->id}}">
                <button  style=" width: 100%;"  type="button" class="btn btn-default">></button></a>
                @endif
                @if(is_null($chappre))
                <a style="float: left;width: 15%;" onclick="return alert('Đây là chap đầu')"><button style="width: 100%;"  type="button" class="btn btn-default"><</button></a>
                @else<a style="float: left;width: 15%;" href="chap/{{$chappre->id}}">
                <button style="width: 100%;" type="button" class="btn btn-default"><</button></a>
                @endif
                 
                                
                              <select style="margin: auto;width: 68%"  class="form-control" onchange="location=this.value;">
                                    @foreach($chaplist as $l)              
                                    <option
                                    @if($chap->id==$l->id)
                                    {{"selected"}}
                                    @endif
                                     value="chap/{{$l->id}}">{{$l->TieuDe}}</option>
                                    @endforeach
                                </select>
           
                </div>

              
        </div>

    </div>