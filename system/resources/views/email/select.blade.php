@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Select Email</h1>
    </div>
  </div>

  <form action="{{route('email.send')}}" method="GET">
    <div class="row table-responsive">

            <table class="table table-striped table-hover">
              <tr>
                <th>No.</th>
                <th>Report Name</th>
                <th>Report Description</th>
                <th>Report Category</th>
                <th>Select Report</th>
              </tr>
              <?php $no = 1 ?>
                @foreach($toReport as $report)
              <tr>
              
                  <td>{{$no++}}</td>
                  <td>{{$report->report->report_Title}}</td>
                  <td>{{$report->report->report_Description}}</td>
                  <td>{{$report->type->typeName}}</td>
                  <td>
                  <input id="status-{{$no}}" type="checkbox" checked data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger"/>
                  <input type="hidden" name="report[]" value="1" id="status-{{$no}}-tick">
                  <input type="hidden" name="id[]" value="{{$report->id}}"></td>
                
              </tr>
              @endforeach
            </table>

    </div>
  <div class="row">
    <div class="clearfix col-md-12">
      <button type="submit" value="save" class="btn btn-primary btn-lg pull-right">Send</button>
    </div>
  </div>
  </form>

@stop