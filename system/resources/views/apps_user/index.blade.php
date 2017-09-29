@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <p class="title">User</p>
    </div>
  </div>
    <div class="row table-responsive">
        <table class="table table-striped table-hover">
          <tr>
            <th class="col-xs-1">No.</th>
            <th class="col-xs-2">Name</th>
            <th class="col-xs-2">Email</th>
            <th class="col-xs-2">Phone</th>
            <th class="col-xs-2">Role</th>
            <th class="col-xs-1">Actions</th>
          </tr>
          <br>
          <?php $no=1; ?>
          @if(count($users) != 0)
          @foreach($users as $user)
            <tr>
              <td class="col-lg-1">{{$no++}}</td>
              <td class="col-lg-2">{{$user->name}}</td>
              <td class="col-lg-2">{{$user->email}}</td>
              <td class="col-lg-2">{{$user->phone}}</td>
              <td class="col-lg-2">{{$user->role->name}}</td>
              <td class="col-lg-1">
                <form class="" action="{{route('apps_user.destroy',$user->id)}}" method="post">
                  <input type="hidden" name="_method" value="delete">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{route('apps_user.show', $user->id)}}" class="btn btn-primary btn-block">Show</a>
                  <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
                </form>
              </td>
            </tr>
          @endforeach
          @endif
        </table>
      </div>
    @if (session('status'))
        <div id="success-alert" class="alert alert-success fade in col-sm-4" style="text-align: center; position: absolute;">
            {{ session('status') }}
        </div>
    @endif
      <script type="text/javascript">
       $(document).ready (function(){ 
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
      });
       });
        
      </script>

      {!! $users->links('pagination') !!}
  @stop