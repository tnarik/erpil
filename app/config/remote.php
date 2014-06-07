<?php

# Remote connections configuration comes from enviroment private configuration
global $app;
$staging = $app->getEnvironmentVariablesLoader()->load('staging');
$production = $app->getEnvironmentVariablesLoader()->load('production');

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Remote Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default connection that will be used for SSH
	| operations. This name should correspond to a connection name below
	| in the server list. Each connection will be manually accessible.
	|
	*/

	'default' => 'staging',

	/*
	|--------------------------------------------------------------------------
	| Remote Server Connections
	|--------------------------------------------------------------------------
	|
	| These are the servers that will be accessible via the SSH task runner
	| facilities of Laravel. This feature radically simplifies executing
	| tasks on your servers, such as deploying out these applications.
	|
	*/

	'connections' => array(
		'staging' => array(
			'host'      => isset($staging['CONNECTION_HOST']) ? $staging['CONNECTION_HOST'] : "",
			'username'  => isset($staging['CONNECTION_USERNAME']) ? $staging['CONNECTION_USERNAME'] : "",
			'password'  => isset($staging['CONNECTION_PASSWORD']) ? $staging['CONNECTION_PASSWORD'] : "",
			'key'       => isset($staging['CONNECTION_KEY']) ? $staging['CONNECTION_KEY'] : "",
			'keyphrase' => isset($staging['CONNECTION_KEYPHRASE']) ? $staging['CONNECTION_KEYPHRASE'] : "",
			'root'      => isset($staging['CONNECTION_ROOT']) ? $staging['CONNECTION_ROOT'] : "",
		),
		'production' => array(
			'host'      => isset($production['CONNECTION_HOST']) ? $production['CONNECTION_HOST'] : "",
			'username'  => isset($production['CONNECTION_USERNAME']) ? $production['CONNECTION_USERNAME'] : "",
			'password'  => isset($production['CONNECTION_PASSWORD']) ? $production['CONNECTION_PASSWORD'] : "",
			'key'       => isset($production['CONNECTION_KEY']) ? $production['CONNECTION_KEY'] : "",
			'keyphrase' => isset($production['CONNECTION_KEYPHRASE']) ? $production['CONNECTION_KEYPHRASE'] : "",
			'root'      => isset($production['CONNECTION_ROOT']) ? $production['CONNECTION_ROOT'] : "",
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Remote Server Groups
	|--------------------------------------------------------------------------
	|
	| Here you may list connections under a single group name, which allows
	| you to easily access all of the servers at once using a short name
	| that is extremely easy to remember, such as "web" or "database".
	|
	*/

	'groups' => array(

		'web' => array('staging')

	),

);
