<?php

Rocketeer::addTaskListeners('deploy', 'after', function($task) {
  

  if ( $task->command->option("migrate") && $task->command->option("seed")) {
    $task->command->info("Migrations and seeds ctivated: database will be initialized");

    Rocketeer::execute(array('CustomTasks\InitializeDatabase'));

  } else {
    $task->command->info("Migrations and seeds deactivated");
  }
});
