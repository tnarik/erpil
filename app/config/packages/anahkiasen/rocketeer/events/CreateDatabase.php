<?php

Rocketeer::addTaskListeners('deploy', 'runComposer', function($task) {
  

  if ( $task->command->option("migrate") ) {
    $task->command->info("Migrations activated: database will be created");

    Rocketeer::execute(array('CustomTasks\CreateDatabase'));

  } else {
    $task->command->info("Migrations deactivated");
  }
});
