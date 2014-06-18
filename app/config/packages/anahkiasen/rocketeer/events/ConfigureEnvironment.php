<?php

Rocketeer::addTaskListeners('deploy', 'runComposer', function($task) {
  $task->command->info("Configuring remote environment based on the connection name");

  $connection = $task->rocketeer->getConnection();
  $currentReleasePath = $task->releasesManager->getCurrentReleasePath();
  $environment_file = "bootstrap".DIRECTORY_SEPARATOR."environment.php";

  $task->remote->putString($currentReleasePath.DIRECTORY_SEPARATOR.$environment_file, "<?php\n return '${connection}';");

  $task->command->info("Created ${environment_file} for environment: ${connection}");
});

Rocketeer::addTaskListeners('deploy', 'runComposer', function($task) {
  $task->command->info("Copying environment settings to remote based on the connection name");

  $connection = $task->rocketeer->getConnection();
  $currentReleasePath = $task->releasesManager->getCurrentReleasePath();
  if ( file_exists(".env.${connection}.php") ) {
    $task->remote->put(".env.${connection}.php", $currentReleasePath.DIRECTORY_SEPARATOR.".env.${connection}.php");
    $task->command->info("Copied .env.${connection}.php");
  } else {
    $task->command->error("Couldn't find .env.${connection}.php");
  }
});