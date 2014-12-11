@extends('layouts.default')
@section('jquery')
	<script>

			$(document).ready(function(){
/*				$('#task-content').on('click','span',function() {
					var task = $(this).html();
					var edit = '<input type="text" id="task" value="'+task+'"></input><button class="save">Save</button>';
					$(this).replaceWith(edit);
					$('button.save').click(function() {
						var id = {{ $task->id }};
						var button = this;
						var new_task = $(document.getElementById('task')).val();
						if(new_task.length > 0)
						{

							$.ajax({
								url: id,
								type: 'PUT',
								data:{task:new_task},
								success: function(result) {
									$(document.getElementById('task')).replaceWith('<span>'+new_task+'</span>');
									$(button).remove();
								},
								error: function(result) {
	alert(result.error);
									$(document.getElementById(id).firstChild).replaceWith('<span>'+task+'</span>');
									$(button).remove();
								}
							});		
						}			

					});
				});
*/
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
alert(this.parentNode.parentNode.id);
					$.ajax({
						url: 'comments/'+this.parentNode.parentNode.id,
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
						        url : "comments",
						        data : dataString,
						        success : function(data){
									var row = '<tr class="comment" id="'+data.id+'" ><td>'+data.user_id+':</td><td>'+comment+'</td><td>'+data.created_at.date+'</td><td><button class="delete">Delete</button></td></tr>'
									$("#comments").append(row);
						        }
						    },"json");
						}

					});

			});
	</script>
@stop

@section('content')
	<div>
		<p>Hi, {{ Auth::user()->given_name }}</p>
	</div>
	<div id="task-content">
		<table>
			{{ Form::open(['route' => 'tasks.store','id' => 'edit-task']) }}
				<td>
					{{ Form::label('task','Task') }}
					{{ Form::text('task',$task->task) }}
				</td>
				<td>
					{{ Form::label('priority','Priority') }}
					{{ Form::select('priority', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), $task->priority) }}
				</td>
				<td>
					{{ Form::label('completed','Completed') }}
					@if($task->completed == '0')
						{{ Form::checkbox('completed','0',false,['id'=>'completed']) }}
					@else
						{{ Form::checkbox('completed','1',true,['id'=>'completed']) }}
					@endif			
				</td>
				<td>
					{{ Form::label('arhive','Archive') }}
					@if($task->archive == '0')
						{{ Form::checkbox('archive','0',false,['id'=>'archive']) }}
					@else
						{{ Form::checkbox('archive','1',true,['id'=>'archive']) }}
					@endif			
				</td>
				<td>{{ Form::submit('Save') }}</td>
			{{ Form::close() }}
		</table>
	</div>
	<div>
		<table id="comments">
			<tr>
			{{ Form::open(['route' => 'tasks.comments.store','id' => 'new-comment']) }}
				<td>
					{{ Form::label('comment','Comment') }}
					{{ Form::text('comment') }}
					{{ Form::hidden('task', $task->task) }}
					{{ Form::hidden('task_id', $task->id) }}
				</td>
	
				<td>{{ Form::submit('Comment') }}</td>
			{{ Form::close() }}
			</tr>
			<tr><th>User id (//replace with name)</th><th>Comments</th><th>Time</th><th>Delete</th></tr>
			@foreach($comments as $comment)
				<tr class="comment" id="{{ $comment->id }}" ><td>{{ $comment->user_id }}:</td><td>{{ $comment->comment }}</td><td>{{ $comment->created_at }}</td>
				@if($comment->user_id == Auth::user()->id)
				<td><button class="delete">Delete</button></td>
				@endif
				</tr>
			@endforeach
		</table>
	</div>
@stop
