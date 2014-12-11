<?php

class ArchiveController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tasks = Task::where('user_id', Auth::user()->id)->where('archive','1')->get();
		return View::make('tasks',['tasks' => $tasks]);
	}


}
