<?php return array(

	// The name of the application to deploy
	// This will create a folder of the same name in the root directory
	// configured above, so be careful about the characters used
	'application_name' => 'erpil',

	// Logging
	////////////////////////////////////////////////////////////////////

	// The schema to use to name log files
	'logs' => function ($rocketeer) {
		return sprintf('%s-%s-%s.log', $rocketeer->getConnection(), $rocketeer->getStage(), date('Ymd'));
	},

	// Remote access
	//
	// You can either use a single connection or an array of connections
	////////////////////////////////////////////////////////////////////

	// The default remote connection(s) to execute tasks on
	'default' => array('staging'),

	// The various connections you defined
	// You can leave all of this empty or remove it entirely if you don't want
	// to track files with credentials : Rocketeer will prompt you for your credentials
	// and store them locally
	// 'connections' are read from the Laravel remote configuration.

	// Contextual options
	////////////////////////////////////////////////////////////////////

	'on' => array(

		// Stages configurations
		'stages' => array(
		),

		// Connections configuration
		'connections' => array(
			'staging' => array(
				'remote'   => include 'staging/remote.php',
			),
		),

	),

);
