@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Add Emergency Contact</h1>
    </div>
  </div>

<div class="panel panel-default">
  <div class="panel-body">
  <form action="{{route('emergency_contact.store')}}" method="POST">
  <input name="_method" type="hidden" value="POST"> {{csrf_field()}}
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Number: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="contact_number">
  	  </div>
  	</div>
  	<br>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Name: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="contact_name">
  	  </div>
  	</div>
  	<br>
  	<div class="row">
  	  <div class="col-md-2">
  		<label>Contact Description: </label>
  	  </div>
  	  <div class="col-md-10">
  		<textarea type="text" class="form-control" name="contact_description"></textarea>
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
        <input id="chk" type="checkbox" checked data-toggle="toggle">
        <input type="hidden" id="status" value="1" name="status">
      </div>
  	  </div>
  	</div>
    <br>
  	<div class="row">
        <div class="clearfix col-md-12">
          <button type="submit" value="save" class="btn btn-primary btn-lg pull-right">Save</button>
        </div>
      </div>
      <br>
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
     </form>
  </div>
</div>
    @stop 