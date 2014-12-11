<?php
	$p='';
	if($pending_tasks->count())
		foreach($pending_tasks as $task)
			$p.='<tr><td>'. $task->task .'</td><td>'. $task->priority .'</td></tr>';
		
	else
		$p='<p>You do not have any pending task currently.</p>';

	$c='';
	if($completed_tasks->count())
		foreach($completed_tasks as $task)
			$c.='<tr><td>'. $task->task .'</td><td>'. $task->priority .'</td></tr>';
		
	else
		$c='<p>You have not completed any task.</p>';

	$a='';
	if($archived_tasks->count())
		foreach($archived_tasks as $task)
			$a.='<tr><td>'. $task->task .'</td><td>'. $task->priority .'</td></tr>';
		
	else
		$a='<p>You do not have any archived task currently.</p>';


    $content = "
<page>
	<div>
		<h1>Pending Tasks</h1>
			<table>
			".$p."
			</table>
	</div>
	<div>
		<h1>Completed Tasks</h1>
			<table>
			".$c."
			</table>
	</div>
	<div>
		<h1>Archived Tasks</h1>
			<table>
			".$a."
			</table>
	</div>
</page>";

require_once('html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P','A4','en');
$html2pdf->WriteHTML($content);
$html2pdf->Output('tasks.pdf','D');
?>


