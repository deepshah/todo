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

				$('table#tasks').on('click','.complete',function() {
					var button = this;
					var dataString = 'c=1'; 

					$.ajax({
						url: 'tasks/'+this.parentNode.parentNode.id,
						type: 'PUT',
						data: dataString,
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

				    $("#search").submit(function(e){
						e.preventDefault();
				        var q = $("input[name=q]").val();
						if(q.length > 0)
						{
						    var token =  $("input[name=_token]").val();
						    $.ajax({
						        type: "GET",
						        url : "tasks?q="+q,
						        success : function(data){
									$("#results").html("");
									for(var i=0;i<data.tasks.length;i++)
									{
										var row = '<li class="list-group-item"><a href="tasks/'+data.tasks[i].id+'">'+data.tasks[i].task+'</a></li>';
										$("#results").append(row);
									}
									$("#search-results").show();
						        }
						    },"json");
						}

					});

				    $("#new-task").submit(function(e){
						e.preventDefault();
				        var task = $("input[name=task]").val();
				        var priority = $("select[name=priority]").val();
						if(task.length > 0)
						{
						    var token =  $("input[name=_token]").val();
						    var dataString = 'task='+task+'&priority='+priority+'&token='+token; 
						    $.ajax({
						        type: "POST",
						        url : "tasks",
						        data : dataString,
						        success : function(data){
									var row = '<tr class="task" id="'+data.id+'" ><td class="editable"><a href="tasks/'+data.id+'">'+task+'</a></td><td>'+priority+'</td><td><button class="complete btn btn-default">Completed</button></td><td><button class="delete btn btn-default">Delete</button></td><td><button class="archive btn btn-default">Archive</button></td></tr>'
									$("#tasks").append(row);
						        }
						    },"json");
						}

					});

			});
	</script>
@stop

@section('content')
<div class="container-fluid">
	<div>
		<div>
		{{ Form::open(['route' => 'tasks.index','id' => 'search']) }}
			<span>
				{{ Form::label('q','Search') }}
				{{ Form::text('q') }}
			</span>
	
			<span>{{ Form::submit('Search',['class' => 'btn btn-default']) }}</span>
		{{ Form::close() }}
		</div>
		<div id="search-results" style="display:none">
		<p>Results:</p>
		<div id="results"></div>
		<br />
		</div>
	</div>
	<br />
	<div>
		<table id="tasks" class="table table-striped">
			<tr>
			{{ Form::open(['route' => 'tasks.store','id' => 'new-task']) }}
				<th>
					{{ Form::label('task','Task') }}
					{{ Form::text('task') }}
				</th>
				<th>
					{{ Form::label('priority','Priority') }}
					{{ Form::select('priority', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), 'Medium' ) }}
				</th>
		
				<th>{{ Form::submit('Save',['class' => 'btn btn-default']) }}</th>
				<th></th>
				<th></th>
			{{ Form::close() }}
			</tr>
		@if($tasks->count())
				<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
				<tr><th>Task</th><th>Priority</th><th>Complete</th><th>Delete</th><th>Archive</th></tr>
			@foreach($tasks as $task)
				<tr class="task" id="{{ $task->id }}" ><td class="editable"><a href="tasks/{{ $task->id }}">{{ $task->task }}</a></td><td>{{ $task->priority }}</td><td><button class="complete btn btn-default">Completed</button></td><td><button class="delete btn btn-default">Delete</button></td><td><button class="archive btn btn-default">Archive</button></td></tr>
			@endforeach

		@else
			<p>You do not have any task currently. Why not create a new task?</p>
		@endif

		</table>
	</div>
</div>
@stop
