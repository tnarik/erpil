<?php
namespace CustomTasks;

use Illuminate\Config\Repository as Config;

class CreateDatabase extends \Rocketeer\Traits\Task {

  protected $name = 'database';

  protected $description = 'Creates the database for the corresponding connection';

  public function execute() {
    $connection = $this->rocketeer->getConnection();

    // Load configuration for the environment (based on the Rocketeer connection) without creating a new app instance
    $config = new Config(
      $this->app->getConfigLoader(), $connection
    );

    $this->command->info("Environment ".$config->getEnvironment());

    switch ($config->get('database.default')) {
      case 'sqlite':
        $this->command->info("Initializing sqlite database");

        // Rewrite the database local path for the current release on the remote
        $remote_path = str_replace($this->app['path'],
            $this->releasesManager->getCurrentReleasePath("{path}"),
            $config->get('database.connections.sqlite.database'));
    
        $this->runForCurrentRelease("touch ${remote_path}");

        break;
    }

  }
}