<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sistema de control de usuarios</title>
	<meta name="viewport" content="width=device-width">
	{{ stylesheet_link_tag() }}
	{{ javascript_include_tag() }}
	@yield('header')
</head>
<body>
	<div class="container-fluid" style="margin-left:0px; margin-right:0px">
		<header style="text-align:center; margin-bottom:50px;">
			<h1> 
				@if(isset($site))
					<a href="/"> {{ $site->name }} </a>
				@else 
					<a href="/">a new site should be created here</a>
				@endif
				@if(isset($user))
				<a style="color:red; font-size:medium; margin-left:30px;" href="{{ URL::route('logout') }}">Cerrar sesión </a>
				@endif
				</h1>
			</header>
			@yield('content')
		</div>
	</body>
	</html>
