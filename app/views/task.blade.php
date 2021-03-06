@extends('layouts.default')
@section('jquery')
	<script>

			$(document).ready(function(){
				    $("#edit-task").submit(function(e){
						e.preventDefault();
				        var task = $("input[name=task]").val();
				        var priority = $("select[name=priority]").val();
						if(document.getElementById('archive').checked)
					        var archive = 1;
						else
							var archive = 0;
						if(document.getElementById('completed').checked)
					        var completed = 1;
						else
							var completed = 0;
						if(task.length > 0)
						{
						    var token =  $("input[name=_token]").val();
						    var dataString = 'task='+task+'&priority='+priority+'&completed='+completed+'&archive='+archive+'&token='+token; 
						    $.ajax({
						        type: "PUT",
						        url : "",
						        data : dataString
						    },"json");
						}

					});

				$('table#comments').on('click','.delete',function() {
					var button = this;
					$.ajax({
						url: 'tasks/comments/'+this.parentNode.parentNode.id,
						type: 'DELETE',
						success: function(result) {
							$(button.parentNode.parentNode).remove();
							}
						});
					});

				    $("#new-comment").submit(function(e){
						e.preventDefault();
				        var comment = $("input[name=comment]").val();
						if(comment.length > 0)
						{
						    var token =  $("input[name=_token]").val();
						    var dataString = 'comment='+comment+'&task_id={{ $task->id }}&token='+token; 
						    $.ajax({
						        type: "POST",
						        url : "tasks/comments",
						        data : dataString,
						        success : function(data){
									var row = '<tr class="comment" id="'+data.id+'" ><td>'+data.user_name+':</td><td>'+comment+'</td><td>'+data.created_at.date+'</td><td><button class="delete btn btn-default">Delete</button></td></tr>'
									$("#comments").append(row);
						        }
						    },"json");
						}

					});

			});
	</script>
@stop

@section('content')
<div class="container-fluid">
	<div id="task-content">
		<table class="table table-striped">
			<tr>
			{{ Form::open(['route' => 'tasks.store','id' => 'edit-task']) }}
				<th>
					{{ Form::label('task','Task') }}
					{{ Form::text('task',$task->task) }}
				</th>
				<th>
					{{ Form::label('priority','Priority') }}
					{{ Form::select('priority', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), $task->priority) }}
				</th>
				<th>
					{{ Form::label('completed','Completed') }}
					@if($task->completed == '0')
						{{ Form::checkbox('completed','0',false,['id'=>'completed']) }}
					@else
						{{ Form::checkbox('completed','1',true,['id'=>'completed']) }}
					@endif			
				</th>
				<th>
					{{ Form::label('arhive','Archive') }}
					@if($task->archive == '0')
						{{ Form::checkbox('archive','0',false,['id'=>'archive']) }}
					@else
						{{ Form::checkbox('archive','1',true,['id'=>'archive']) }}
					@endif			
				</th>
				<th>{{ Form::submit('Save',['class' => 'btn btn-default']) }}</th>
			{{ Form::close() }}
			</tr>
		</table>
	</div>
	<br />
	<div>
		<table id="comments" class="table table-striped">
			<tr>
			{{ Form::open(['route' => 'tasks.comments.store','id' => 'new-comment']) }}
				<th>
					{{ Form::label('comment','Comment') }}
					{{ Form::text('comment') }}
				</th>
				<th>{{ Form::submit('Comment',['class' => 'btn btn-default']) }}</th>
				<th>
					{{ Form::hidden('task', $task->task) }}
					{{ Form::hidden('task_id', $task->id) }}
				</th>
				<th></th>	
			{{ Form::close() }}
			</tr>
		@if($comments->count())
				<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
				<tr><th>User id (//replace with name)</th><th>Comments</th><th>Time</th><th>Delete</th></tr>
				@foreach($comments as $comment)
					<tr class="comment" id="{{ $comment->id }}" ><td>{{ $comment->user_name }}:</td><td>{{ $comment->comment }}</td><td>{{ $comment->created_at }}</td>
					@if($comment->user_id == Auth::user()->id)
					<td><button class="delete btn btn-default">Delete</button></td>
					@endif
					</tr>
				@endforeach
		@endif
		</table>
	</div>
</div>
@stop
