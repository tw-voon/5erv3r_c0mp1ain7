@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-8">
      <p class="title">Report Category Management</p>
    </div>
    <div class="col-md-4">
      <a href="{{route('report_types.create')}}" class="btn btn-info pull-right">Create New Category</a>
    </div>
  </div>
	<br>
  <div class="row table-responsive">
        <table class="table table-striped table-hover">
          <tr>
            <th class="col-sm-1">No.</th>
            <th class="col-sm-7">Report Type Name</th>
            <th class="col-sm-2">Auto Report</th>
            <th class="col-sm-2">Actions</th>
          </tr>          
          <?php $no=1; ?>
          @if(count($types) != 0)
          @foreach($types as $type)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$type->name}}</td>
              <td>
              @if($type->is_auto_report == 1)
                <input id="status" type="checkbox" checked data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" disabled />
              @else
                <input id="status" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" disabled/>
              @endif
              </td>
              <td class="col-md-2">
                <form class="" action="{{route('report_types.destroy',$type->id)}}" method="post">
                  <input type="hidden" name="_method" value="delete">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{route('report_types.edit',$type->id)}}" class="btn btn-primary btn-block">Edit</a>
                  <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
                </form>
              </td>
            </tr>
          @endforeach
          @endif
        </table>
  @stop