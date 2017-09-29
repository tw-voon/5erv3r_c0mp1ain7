@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Show user details</h1>
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">

    <div class="row">
      <div class="col-md-2">
      <label>Name: </label>
      </div>
      <div class="col-md-10">
      <input type="text" disabled="true" class="form-control" name="category_name" value="{{$user->name}}">
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-2">
      <label>Email: </label>
      </div>
      <div class="col-md-10">
      <input type="text" class="form-control" disabled="true" name="category_name" value="{{$user->email}}">
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-2">
      <label>Password: </label>
      </div>
      <div class="col-md-10">
      <input type="text" class="form-control" disabled="true" name="category_name" value="{{$user->password}}">
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-2">
      <label>Firebase ID: </label>
      </div>
      <div class="col-md-10">
      <input type="text" class="form-control" disabled="true" name="category_name" value="{{$user->firebaseID}}">
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-2">
      <label>Avatar: </label>
      </div>
      <div class="col-md-10">
      <img src="{{$user->avatar_link}}">
      </div>
    </div>

    <br>

    <div class="row">
        <div class="clearfix col-md-12">
          <a type="button" href="{{route('apps_user.index')}}" class="btn btn-primary btn-lg pull-right">Back</a>
        </div>
      </div>
  </div>
    
</div>
    @stop 



