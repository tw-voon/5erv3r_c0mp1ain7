@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-8">
      <p class="title">Tips Details Management - {{$name->name}}</p>
    </div>
    <div class="col-md-4">
      <a href="{{route('tip_category.create', $name->id)}}" class="btn btn-info pull-right">Create New Tips</a>
    </div>
  </div>
	<br>
  {{$name->category_name}}
  <div class="row table-responsive">
    <table class="table table-striped table-hover">
      <tr>
        <th class="col-sm-1">No.</th>
        <th class="col-sm-3">Tips Name</th>
        <th class="col-sm-5">Tips Description</th>
        <th class="col-sm-1">Status</th>
        <th class="col-sm-2">Actions</th>
      </tr>
      <?php $no=1; ?>
      @if(count($tips) != 0)
      @foreach($tips as $tip)
      <tr>
        <td>{{$no++}}</td>
        <td>{{$tip->title}}</td>
        <td>{{$tip->message}}</td>
        <td>
              @if($tip->status == 1)
              <input id="status-{{$no}}" type="checkbox" checked data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" disabled />
              @else
              <input id="status-{{$no}}" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" disabled/>
              @endif
              </td>
        <td>
          <form class="" action="{{route('tip_category.destroy',$tip->id)}}" method="post">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a href="{{route('tip_category.edit',$tip->id)}}" class="btn btn-primary btn-block">Edit</a>
            <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
          </form>
        </td>
      </tr>
      @endforeach
      @endif
    </table>
  </div>          
  @stop