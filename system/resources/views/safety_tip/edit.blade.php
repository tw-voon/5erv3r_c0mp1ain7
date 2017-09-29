@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Edit Category</h1>
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">
  <form action="{{route('safety_tip.update',$category->id)}}" method="POST">
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
  		<label>Name: </label>
  	  </div>
  	  <div class="col-md-10">
  		<input type="text" class="form-control" name="category_name" value="{{$category->name}}">
  	  </div>
  	</div>
  	<br>
  	<div class="row">
        <div class="clearfix col-md-12" onload="getvalue()">
          <button type="submit" value="save" class="btn btn-primary btn-lg pull-right">Update</button>
        </div>
      </div>
     </form>
  </div>
    
</div>
    @stop 



