@extends('master')
  @section('content')
  <div class="row">
    <form action="{{route('query')}}" method="GET">

      <div class="col-sm-6">
        <p class="title">Report</p>
      </div>

      <div class="col-sm-2 form-group">
        <select class="form-control" id="sel1">
          @if(!isset($_GET['category']))
            <option value="0">All</option>
            <option value="1">Solved Complaint</option>
            <option value="2">Unsolved Complaint</option>
            <option value="3">Unassigned Officer</option>
          @else

            <option value="0">All</option>

            @if($_GET['category'] == 1)
              <option value="1" selected="true">Solved Complaint</option>
            @else 
              <option value="1">Solved Complaint</option>
            @endif

            @if($_GET['category'] == 2)
              <option value="2" selected="true">Unsolved Complaint</option>
            @else 
              <option value="2">Unsolved Complaint</option>
            @endif

            @if($_GET['category'] == 3)
              <option value="3" selected="true">Unassigned Officer</option>
            @else 
              <option value="3">Unassigned Officer</option>
            @endif

          @endif
        </select>
        <input id="category" type="hidden" value="0" name="category">
      </div>

      <div class="col-sm-3">
        @if(!isset($_GET['query']))
          <input type="text" class="form-control" name="query" placeholder="Search">
        @else 
          <input type="text" class="form-control" name="query" value="{{$_GET['query']}}" placeholder="Search">
        @endif
      </div>
      
      <div class="col-sm-1">
        <button class="btn btn-primary" type="submit">
            Search
          </button>
      </div>

    </form>
  </div>
    <div class="row table-responsive">
        <table class="table table-striped table-hover">
          <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Assigned to</th>
            <th>Status</th>
            <th>Submitted on</th>
            <th>Actions</th>
          </tr>
          <br>
          <?php $no=1; ?>
          @if(count($data) != 0)
          @foreach($data as $report)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$report->title}}</td>
              <td>{{$report->category->name}}</td>
              <td>{{$report->location->name}}</td>
              <td>
                @if ($report->officer_id == null) 
                  No Assigned
                @else 
                  {{$report->officer->name}}
                @endif
              </td>  
              <td>{{$report->status->name}}</td>
              <td>{{$report->created_at}}</td>
              <td>
                <form class="" action="{{route('report.destroy',$report->id)}}" method="post">
                  <input type="hidden" name="_method" value="delete">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{route('report.edit',$report->id)}}" class="btn btn-primary btn-block">Show</a>
                  <input type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this data');" name="name" value="delete">
                </form>
              </td>
            </tr>
          @endforeach
          @endif
        </table>
      </div>

    @if(count($data) == 0)

    <div class="clearfix" style="margin-top: 10px; margin-left: auto; margin-right: auto; text-align: center;">
      <img src="{{URL::asset('/sys_images/no_results.png')}}">
    </div>

    @endif



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

      @if(count($data) != 0)
        {!! $data->appends(request()->input())->links('pagination') !!}
      @endif

      <script>
        $("#sel1").click(function(){
          $('#category').val($("#sel1").val())
        });
      </script>
  @stop