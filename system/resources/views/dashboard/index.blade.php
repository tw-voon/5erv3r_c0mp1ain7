@extends('master')
  @section('content')

<div class="row">

	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">Total Apps User</div>
  			<div class="panel-body">
  				<div class="row">
  					<div class="col-md-4">
  						<span class="glyphicon glyphicon-user"></span>
  					</div>
  					<div class="col-md-8">
						<h3>{{$users}} User</h3>
					</div>
  				</div>
  			</div>
		</div>
	</div>

	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">Total Post Pending</div>
  			<div class="panel-body">
  					<div class="row">
  						<div class="col-md-4">
  							<span class="glyphicon glyphicon-list-alt"></span>
  						</div>
  						<div class="col-md-8">
  							<h3>{{$unapprove}} Post</h3>
  						</div>
  					</div>
  			</div>
		</div>
	</div>

	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">Frequent Report Type</div>
  			<div class="panel-body">
  					<div class="row">
  						<div class="col-md-3">
  							<span class="glyphicon glyphicon-fire"></span>
  						</div>
  						<div class="col-md-8">
  							<h3>{{$trend->name}}</h3>
  						</div>
  					</div>
  			</div>
		</div>
	</div>
	
</div>

<div class="row">

  <div class="col-md-8">

	 <div class="panel panel-default">

		<div class="panel-heading">

      <div class="row">

        <div class="col-md-1"> <p>Map</p> </div> 

        <form action="{{route('dashboard.filter')}}" method="GET">
      
          <div class="col-md-9"> 

            <select id="filters" name="filter" class="form-control"> 
              <option value="0">All</option>
              @foreach($types as $type)
                @if(isset($_GET['filter']))
                  @if($_GET['filter'] == $type->id)
                    <option value="{{$type->id}}" selected="true">{{$type->name}}</option>
                  @else
                    <option value="{{$type->id}}">{{$type->name}}</option>
                  @endif
                @else 
                  <option value="{{$type->id}}">{{$type->name}}</option>
                @endif
              @endforeach
            </select>

          </div>

          <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>

        </form>
      </div>
    </div>

  	<div class="panel-body">
			<div style="width: 100%; height: 500px;">
					{!! Mapper::render() !!}
			</div>
		</div>

	</div>

</div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading"> Complaint Submitted by Month (2017) </div>
      <div class="panel-body">
        <div id="chart-div"></div>
          <?= $charts::render('ColumnChart', 'Total Complaint', 'chart-div'); ?>
      </div>
    </div>
  </div>
</div>




  @stop