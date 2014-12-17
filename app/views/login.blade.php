@extends('layouts.default')
@section('content')
<div class="container-fluid">
	<p>Please log in to access To Do</p>
	<a class="login" href="{{ $authUrl }}">Login via Google</a>
</div>
@stop
