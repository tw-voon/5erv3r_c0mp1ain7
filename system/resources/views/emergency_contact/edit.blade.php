@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Edit Emergency Contact</h1>
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">
  <form action="{{route('emergency_contact.update',$contacts->id)}}" method="POST">
  <input name="_method" type="hidden" value="PATCH"> {{csrf_field()}}
  <div class="row">
        <div class="clearfix col-md-12">
      @if (count($errors) > 0)
        <div class="alert alert-warning">
           <ul>
             @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
             @endforeach
            </ul>
        </div>
    @endif
        </div>
      </div>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Number: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="contact_number" value="{{$contacts->number}}">
  	  </div>
  	</div>
  	<br>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Name: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="contact_name" value="{{$contacts->name}}">
  	  </div>
  	</div>
  	<br>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Description: </label>
  	  </div>
  	  <div class="col-md-10">
  		<textarea type="text" class="form-control" name="contact_description">{{$contacts->description}}</textarea>
  	  </div>
  	</div>
  	<br>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Status: </label>
  	  </div>
  	  <div class="col-md-10 check">
      <div id="selected">
      <!-- <input id="chk1" type="checkbox" checked data-toggle="toggle"> -->
        @if($contacts->status == 1)
        <input id="chk" type="checkbox" checked data-toggle="toggle">
        <input type="hidden" id="status" value="{{$contacts->status = 1}}" name="status">
        <!-- <input type="text" name="status" value="{{$contacts->status = 1}}"> -->
        @else
        <input id="chk" type="checkbox" data-toggle="toggle">
        <input type="hidden" id="status" value="{{$contacts->status = 1}}" name="status">
        <!-- <input type="text" name="status" value="{{$contacts->status = 2}}"> -->
        @endif
        
      </div>
  	  </div>
  	</div>
  	<div class="row">
        <div class="clearfix col-md-12" onload="getvalue()">
          <button type="submit" value="save" class="btn btn-primary btn-lg pull-right">Update</button>
        </div>
      </div>
     </form>
  </div>
    
</div>
    @stop 



