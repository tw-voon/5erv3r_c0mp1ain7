@extends('layouts.app')

@section('content')

<!-- <div class="container"> -->
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                <a role="button" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
@endsection
