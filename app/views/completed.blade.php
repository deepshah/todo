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
<div class="container-fluid">
	<div>
		{{ Form::open(['route' => 'tasks.index','method'=>'GET','id' => 'search']) }}
			<span>
				{{ Form::label('q','Search') }}
				{{ Form::text('q') }}
			</span>
	
			<span>{{ Form::submit('Search',['class' => 'btn btn-default']) }}</span>
		{{ Form::close() }}

	</div>
	<br />
	<div>
		<table id="tasks" class="table table-striped">
		@if($tasks->count())
			<tr><th>Task</th><th>Priority</th><th>Delete</th><th>Archive</th></tr>
			@foreach($tasks as $task)
				<tr class="task" id="{{ $task->id }}" ><td class="editable"><a href="tasks/{{ $task->id }}">{{ $task->task }}</a></td><td>{{ $task->priority }}</td><td><button class="delete btn btn-default">Delete</button></td><td><button class="archive btn btn-default">Archive</button></td></tr>
			@endforeach
		@endif


		</table>
	</div>
</div>
@stop
