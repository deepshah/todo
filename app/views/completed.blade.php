@extends('layouts.default')
@section('jquery')
	<script>
			$(document).ready(function(){
				$('table#tasks').on('click','.delete',function() {
					var button = this;
					$.ajax({
						url: 'tasks/'+this.parentNode.parentNode.id,
						type: 'DELETE',
						success: function(result) {
							$(button.parentNode.parentNode).remove();
							}
						});
					});


				$('table#tasks').on('click','.archive',function() {
					var button = this;
					var dataString = 'a=1'; 

					$.ajax({
						url: 'tasks/'+this.parentNode.parentNode.id,
						type: 'PUT',
						data: dataString,
						success: function(result) {
							$(button.parentNode.parentNode).remove();
							}
						});
					});


			});
	</script>
@stop

@section('content')
	<div>
		<p>Hi, {{ Auth::user()->given_name }}</p>
	</div>
	<div>
		{{ Form::open(['route' => 'tasks.index','method'=>'GET','id' => 'search']) }}
			<span>
				{{ Form::label('q','Search') }}
				{{ Form::text('q') }}
			</span>
	
			<span>{{ Form::submit('Search') }}</span>
		{{ Form::close() }}

	</div>
	<div>
		<table id="tasks">
		@if($tasks->count())
			<tr><th>Task</th><th>Priority</th><th>Delete</th><th>Archive</th></tr>
			@foreach($tasks as $task)
				<tr class="task" id="{{ $task->id }}" ><td class="editable"><a href="tasks/{{ $task->id }}">{{ $task->task }}</a></td><td>{{ $task->priority }}</td><td><button class="delete">Delete</button></td><td><button class="archive">Archive</button></td></tr>
			@endforeach
		@endif


		</table>
	</div>
	<div><a href="archives">Archives</a></div>
@stop