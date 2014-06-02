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

	<script>
		$(document).ready(function() {
			$('.alert').delay(5000).fadeOut(400);
		})
	</script>
</head>
<body>
	@if (Session::has('flash_message'))
		@foreach (Session::get('flash_message') as $flash_type => $flash_message )
    		<div class="alert alert-{{ $flash_type }}">
    			{{ $flash_message }}
    		</div>
    	@endforeach
    @endif
	<div class="container-fluid" >
		<header style="text-align:center; margin-bottom:50px;">
			<h1> 
				@if(isset($current_site))
					<a href="/"> {{ $current_site->name }} </a>
				@else 
					<a href="/">[[ demo ]]</a>
				@endif
				@if(isset($current_user))
					<a style="color:red; font-size:medium; margin-left:30px;" href="{{ URL::route('logout') }}"><span class="glyphicon glyphicon-log-out"></span> Salir del sistema</a>
				@endif
			</h1>
		</header>
		@yield('content')
	</div>
</body>
</html>
