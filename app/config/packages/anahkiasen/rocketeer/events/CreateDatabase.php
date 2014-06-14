<?php

Rocketeer::addTaskListeners('deploy', 'runComposer', function($task) {
  $task->command->info("Creating database");

  Rocketeer::execute(array('CustomTasks\CreateDatabase'));

   $currentReleasePath = $task->releasesManager->getCurrentReleasePath();

   $task->remote->put("app/database/seeds/ImportTableSeeder.php", $currentReleasePath.DIRECTORY_SEPARATOR."app/database/seeds/ImportTableSeeder.php");
   $task->remote->put("app/database/seeds/DatabaseSeeder_temp.php", $currentReleasePath.DIRECTORY_SEPARATOR."app/database/seeds/DatabaseSeeder.php");

  $task->command->info("Created database");
});
