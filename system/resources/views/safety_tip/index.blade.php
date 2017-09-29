@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-8">
      <p class="title">Safety Tips Category Management</p>
    </div>
    <div class="col-md-4">
      <a href="{{route('safety_tip.create')}}" class="btn btn-info pull-right">Create New Category</a>
    </div>
  </div>
	<br>
  <div class="row table-responsive">
        <table class="table table-striped table-hover">
          <tr>
            <th>No.</th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
          <?php $no=1; ?>
          @if(count($tips) != 0)
          @foreach($tips as $tip)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$tip->name}}</td>
              <td class="col-md-2">
                <form class="" action="{{route('safety_tip.destroy',$tip->id)}}" method="post">
                  <input type="hidden" name="_method" value="delete">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{route('tip_category.index',$tip->id)}}" class="btn btn-primary btn-block">View Detail</a>
                  <a href="{{route('safety_tip.edit',$tip->id)}}" class="btn btn-primary btn-block">Edit</a>
                  <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
                </form>
              </td>
            </tr>
          @endforeach
          @endif
        </table>
  @stop