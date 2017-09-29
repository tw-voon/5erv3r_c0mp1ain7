@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-8">
      <p class="title">Hotline Number Management</p>
    </div>
    <div class="col-md-4">
      <a href="{{route('emergency_contact.create')}}" class="btn btn-info pull-right">Create New Contact</a>
    </div>
  </div>
	<br>
  <div class="row table-responsive">
        <table class="table table-striped table-hover">
          <tr>
            <th>No.</th>
            <th>Contact Number</th>
            <th>Contact Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Actions</th>
          </tr>          
          <?php $no=1; ?>
          @if(count($contacts) != 0)
          @foreach($contacts as $contact)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$contact->number}}</td>
              <td>{{$contact->name}}</td>
              <td>{{$contact->description}}</td>
              <td>
              @if($contact->status == 1)
              <input id="status-{{$no}}" type="checkbox" checked data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" disabled />
              @else
              <input id="status-{{$no}}" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" disabled/>
              @endif
              </td>
              <td>{{$contact->created_at}}</td>
              <td>
                <form class="" action="{{route('emergency_contact.destroy',$contact->id)}}" method="post">
                  <input type="hidden" name="_method" value="delete">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{route('emergency_contact.edit',$contact->id)}}" class="btn btn-primary btn-block">Edit</a>
                  <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
                </form>
              </td>
            </tr>
          @endforeach
          @endif
        </table>
        @if (session('status'))
        <div id="success-alert" class="alert alert-success fade in col-sm-4" style="text-align: center; position: absolute;">
            {{ session('status') }}
        </div>
    @endif
        {!! $contacts->links('pagination') !!}
  @stop