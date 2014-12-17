<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To Do</title>

	<base href="http://localhost/pb/todo/public/">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style>
		body { padding-top: 180px; }
	</style>

	@yield('jquery')
  </head>
  <body>
	@yield('content')
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		  <div class="container">
			<div class="row page-header">
			  <div class="col-md-9"><a href=""><h1>To Do</h1></a></div>
				@if(Auth::check())
			  <div class="col-md-2"><img class="img-circle" src="{{ Auth::user()->picture }}?sz=30" /> Hi, {{ Auth::user()->given_name }}!</div>
			  <div class="col-md-1"><a href="logout">Logout</a></div>
				@endif
			</div>
		  </div>
		</nav>
		@if(Auth::check())
		<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
		  <div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="">Home</a></li>
			  <li role="presentation"><a href="tasks?c=true">Completed Tasks</a></li>
			  <li role="presentation"><a href="archives">Archives</a></li>
			  <li role="presentation"><a href="tasks?pdf=true">Create PDF</a></li>
			</ul>
		</nav>
		@endif
  </body>
</html>
