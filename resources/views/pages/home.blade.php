@extends('layouts.master')

@section('stylesheets')
    <link href="css/app.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css">
@stop
@section('content')

    <div id="app" class="content white-bg">
        <app></app>
    </div>

@section('scripts')
    <script src="{{ mix('js/app.js') }}" ></script>
@stop

@stop
