@extends('master')
  @section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Edit Data</h1>
    </div>
  </div>
  <div class="row">
    <form class="" action="{{route('report.update',$blog->id)}}" method="post">
      <input name="_method" type="hidden" value="PATCH">
      {{csrf_field()}}
      <div class="form-group{{ ($errors->has('report_Title')) ? $errors->first('report_Title') : '' }}">
        <label>Report Title: </label>
        <input type="text" name="report_Title" class="form-control" placeholder="Enter Title Here" value="{{$blog->report_Title}}">
        {!! $errors->first('report_Title','<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ ($errors->has('description')) ? $errors->first('title') : '' }}">
        <label>Report Description: </label>
        <input type="text" name="report_Description" class="form-control" placeholder="Enter Description Here" value="{{$blog->report_Description}}">
        {!! $errors->first('report_Description','<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="save">
      </div>
    </form>
  </div>
  @stop