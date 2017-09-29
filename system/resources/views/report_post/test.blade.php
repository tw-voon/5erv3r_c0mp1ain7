@extends('master')
  @section('content')

  <div class="container">

    <!-- {{$report}} -->

    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">

          <div class="col-md-4">
            <img id="complaint_img" data-toggle="modal" data-target="#picModal" src="{{$report[0]->media->link}}" style="margin-bottom: 5px;"> 

              <br><br>

            <span class="glyphicon glyphicon-time"></span>
            <label>Submitted on : {{$report[0]->created_at}}</label>

              <br>

            <div class="dropdown">

              <span class="glyphicon glyphicon-eye-open"></span>
                @if($report[0]->officer_id == null)
                  <label class="dropdown-toggle" type="button" data-toggle="dropdown">Assigned to : No Officer Assigned yet  </label>
                @else
                  <label class="dropdown-toggle" type="button" data-toggle="dropdown">Assigned to : {{$report[0]->officer->name}}  </label>
                @endif

                <span class="glyphicon glyphicon-pencil"></span>

                <ul class="dropdown-menu">
                  <li><a href="#" data-toggle="modal" data-target="#officerModal">Assign/ Change Officer</a></li>
                </ul>

            </div>

            <span class="glyphicon glyphicon-heart"></span>
            <label>Supported ({{$report[0]->support}})</label>

            <div>
              <span class="glyphicon glyphicon-star"></span>
              <label>Affected ({{$report[0]->affected}})</label>
            </div>


          </div>

          

    <div class="col-md-8">
      <div class="table-responsive">          
        <table class="table">
        <tbody>
          <tr>
            <p style="font-size: 18px; font-style: bold;">{{$report[0]->title}}</p>
          </tr>
          <tr>
          <td>
            <span class="mdl-chip">
            <span class="mdl-chip__text">{{$report[0]->category->name}}</span>
            </span>
          </td>
            
          </tr>
          <tr>
            <td>
              <p>{{$report[0]->description}}</p>
            </td>
            
          </tr>
          <tr>
            <td>
              <a type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"> 
                <i class="material-icons" style="font-size:16px">place</i> Location : {{$report[0]->location->name}}</a>
            </td>
          </tr>
          <tr>
            <td>
              
            </td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
  </div>

  </div>
  </div>

  <!-- Second row -->

    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-11">Action taken</div> 
            <div class="col-md-1">
              <button class="btn btn-primary" data-toggle="modal" data-target="#actionModal">Add <span class="glyphicon glyphicon-plus"></span></button>
            </div>
          </div>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-hover">

            @if($report[0]->action != null)
              @foreach($report[0]->action as $action)

              @if($loop->first)

                <tr class="active">
                  <td class="col-sm-1" style="width: 30px;">
                    <img src="{{URL::asset('/sys_images/current_act_.png')}}" style="height: 20px; width: 20px; vertical-align: middle">
                  </td>
                  <td class="col-md-10">
                    <p class="text-left">{{$action->action_taken}}</p>
                  </td>
                  <td>
                    @if($action->link != null)
                      <img src="{{$action->link}}" style="max-height: 200px;">
                    @else
                      No Attachment found
                    @endif
                  </td>
                  <td class="col-md-2">
                    {{$action->created_at}}
                  </td>
                </tr>

                @else

                <tr>
                  <td>
                    <img src="{{URL::asset('/sys_images/previous_act_.png')}}" style="height: 20px; width: 20px;">
                  </td>
                  <td>
                    {{$action->action_taken}}
                  </td>
                  <td>
                    @if($action->link != null)
                      <img src="{{$action->link}}" style="max-height: 200px;">
                    @else
                      No Attachment found
                    @endif
                  </td>
                  <td>
                    {{$action->created_at}}
                  </td>
                </tr>

                @endif
              @endforeach
            @endif

        </div>
      </div>
    </div>

  </div>

  <!-- Modal -->

  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$report[0]->location->name}}</h4>
      </div>
      <div class="modal-body">
        <div id="map"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEw4F7C21g9g3i7JnsNIemUxLUH2NpVDk&callback=initMap">
  </script>

  <script>
    function initMap() {
      var uluru = {lat: 1.5569828, lng: 110.2479109};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: uluru,
        zoomControl: false,
      });
      var marker = new google.maps.Marker({
        position: uluru,
        map: map
      });
    }

    $("#myModal").on("shown.bs.modal", function () {
      // var currentCenter = map.getCenter();
      // google.maps.event.trigger(map, "resize");
      // map.setCenter(currentCenter);
      initMap();
    });
    </script>
</div>

<div id="picModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$report[0]->title}}</h4>
      </div>
      <div class="modal-body">
        <img id="complaint_img" src="{{$report[0]->media->link}}"> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="officerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{route('officer',$report[0]->id)}}" method="POST"> 
        <input name="_method" type="hidden" value="POST">
      {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign/ Change Officer</h4>
      </div>
      <div class="modal-body">
        <ul class="demo-list-control mdl-list">
          @foreach($officers as $officer)
            @if($officer->id != $report[0]->officer_id)

            <li class="mdl-list__item">
              <span class="mdl-list__item-primary-content">
                <i class="material-icons  mdl-list__item-avatar">person</i>
                {{$officer->name}}
              </span>
              <span class="mdl-list__item-secondary-action">
                <label class="demo-list-radio mdl-radio mdl-js-radio mdl-js-ripple-effect">
                  <input type="radio" id="list-option-1" class="mdl-radio__button" name="officer" value="{{$officer->id}}" />
                </label>
              </span>
            </li>

            @endif
          @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>

  </div>
</div>

<div id="actionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{route('action',$report[0]->id)}}" method="POST" enctype="multipart/form-data"> 
        <input name="_method" type="hidden" value="POST">
      {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Action</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Action taken: </label>
          <input type="text" class="form-control" id="action_taken" name="action_taken">
        </div>
        <div class="form-group">
          <label>Will this step solve the complaint ?</label>
          <label class="radio-inline"><input type="radio" name="status" value="1">Yes</label>
          <label class="radio-inline"><input type="radio" name="status" value="2" checked="true">No</label>
        </div>
        <div class="form-group">
          <input type="file" name="file" id="files" accept="image/*"> <br>
          <img id="image" style="width: 550px; height: auto;" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>

  </div>

  <script>
  document.getElementById("files").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("image").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
</script>

</div>


@stop