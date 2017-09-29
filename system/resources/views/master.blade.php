<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaint Management Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/complaint.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-app="">
  <div class="row">
    @include('layouts.header')
  </div>
  <div id="wrapper" class="row">
    <div class="overlay"></div>
      @include('layouts.navigational') 
  <div id="page-content-wrapper">
    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
      <span class="hamb-top"></span>
      <span class="hamb-middle"></span>
      <span class="hamb-bottom"></span>
            </button>
  <div class="container">
      <div class="row">
        @yield('content')
      </div>
    </div>
  </div>
  @if (session('success'))
  <div id="message">
    <div style="padding: 5px;">
      <div id="inner-message" class="alert alert-error">
        <div id="success-alert" class="alert alert-success fade in col-sm-4" style="text-align: center; position: relative;">
            {{ session('success') }}
        </div>
      </div>
    </div>
  </div>
  @endif
  @if (session('fail'))
  <div id="message">
    <div style="padding: 5px;">
      <div id="inner-message" class="alert alert-error">
        <div id="success-alert" class="alert alert-danger fade in col-sm-4" style="text-align: center; position: relative;">
            {{ session('fail') }}
        </div>
      </div>
    </div>
  </div>
  @endif
  </body>
</html>