@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Edit Safety Tips</h1>
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">
  <form action="{{route('tip_category.update',$name->id)}}" method="post">
  <input name="_method" type="hidden" value="PATCH"> {{csrf_field()}}

  	<div class="row">
  	  <div class="col-md-2">
  		<label>Tip Name: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="tip_name" value="{{$name->title}}">
  	  </div>
  	</div>

  	<br>

  	<div class="row">
  	  <div class="col-md-2">
  		<label>Tip Description: </label>
  	  </div>
  	  <div class="col-md-10">
  		<textarea type="text" class="form-control" name="tip_desc">{{$name->message}}</textarea>
  	  </div>
  	</div>

  	<br>

  	<div class="row">
  	  <div class="col-md-2">
  		<label>Status: </label>
  	  </div>
  	  <div class="col-md-10 check">
      <div id="selected">
        @if($name->status == 1)
        <input id="chk" type="checkbox" checked data-toggle="toggle">
        <input type="hidden" id="status" value="{{$name->status}}" name="status">
        @else
        <input id="chk" type="checkbox" data-toggle="toggle">
        <input type="hidden" id="status" value="{{$name->status}}" name="status">
        @endif
      </div>
  	  </div>
  	</div>
  	<div class="row">
        <div class="clearfix col-md-12">
          <button type="submit" value="save" class="btn btn-primary btn-lg pull-right">Update</button>
        </div>
      </div>
     </form>
  </div>
    
</div>
    @stop 



