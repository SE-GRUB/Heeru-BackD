@extends('backend.layout')

@section('title', 'Dashboard')
@section('icon', 'tachometer-fast')

@section('content')
    <!-- Add your index page content here -->
    <h4>Welcome to Heeru, <b>{{Auth::user()->name}}</b>!<br>You're logged in as <b>{{Auth::user()->role}}</b>.</h4>
    <!-- Add more content as needed -->
@endsection