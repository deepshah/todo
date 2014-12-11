<?php

class CommentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$comment = new Comment;
		$comment->comment = Request::get('comment');
		$comment->task_id = Request::get('task_id');
		$comment->user_id = Auth::user()->id;
		$comment->save();

		$comment = Comment::where('id',$comment->id)->get()[0];
		return Response::json(array(
		    'error' => false,
		    'id' => $comment->id,
			'user_id' => $comment->user_id,
			'comment' => $comment->comment,
			'created_at' => $comment->created_at),
		    200
		);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$comment = Comment::where('user_id', Auth::user()->id)->find($id);
	 
		$comment->delete();
	 
		return Response::json(array(
		    'error' => false,
		    'id' => $id),
		    200
		    );
	}


}
