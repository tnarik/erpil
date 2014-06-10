<?php

Rocketeer::addTaskListeners('deploy', 'runComposer', function ($task) {
  $task->command->info("Configuring environment based on the connection name");

  $connection = $task->rocketeer->getConnection();
  $currentReleasePath = $task->releasesManager->getCurrentReleasePath();
  $environment_file = "bootstrap".DIRECTORY_SEPARATOR."environment.php";

  $task->remote->putString($currentReleasePath.DIRECTORY_SEPARATOR.$environment_file, "<?php\n return '${connection}';");

  $task->command->info("Created ${environment_file}");
});

Rocketeer::addTaskListeners('deploy', 'runComposer', function($task) {
  $task->command->info("Copying environment settings based on the connection name");

  $connection = $task->rocketeer->getConnection();
  $currentReleasePath = $task->releasesManager->getCurrentReleasePath();

  $task->remote->put(".env.${connection}.php", $currentReleasePath.DIRECTORY_SEPARATOR.".env.${connection}.php");

  $task->command->info("Created .env.${connection}.php");
});