@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Edit Category Name: </h1>
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">
  <form action="{{route('report_types.update',$type->id)}}" method="post">
  <input name="_method" type="hidden" value="PATCH"> {{csrf_field()}}

  	<div class="row">
  	  <div class="col-md-2">
  		<label>Category Name: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="typeName" value="{{$type->name}}">
  	  </div>
  	</div>

  	<br>

  	<div class="row">
  	  <div class="col-md-2">
  		<label>Set Auto Report: </label>
  	  </div>
  	  <div class="col-md-10 check">
      <div id="selected">
        @if($type->is_auto_report == 1)
        <input id="chk" type="checkbox" checked data-toggle="toggle">
        <input type="hidden" id="status" value="{{$type->is_auto_report}}" name="isAutoReport">
        @else
        <input id="chk" type="checkbox" data-toggle="toggle">
        <input type="hidden" id="status" value="{{$type->is_auto_report}}" name="isAutoReport">
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



