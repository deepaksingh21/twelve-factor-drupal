<?php

/**
 * @file
 * Integrates DB settings as parsed from environment variables.
 */

// Load .env file if it exists
if (file_exists(dirname(DRUPAL_ROOT) . '/.env')) {
  // Load environment
  $dotenv = new Dotenv\Dotenv(dirname(DRUPAL_ROOT));
  $dotenv->load();

  // Require DATABASE_URL to be defined
  $dotenv->required('DATABASE_URL')->notEmpty();
}



if (getenv('DATABASE_URL') !== FALSE) {
  $dsn_info = parse_url(getenv('DATABASE_URL'));
  $databases['default']['default'] = array (
    'database' => str_replace('/', '', $dsn_info['path']),
    'username' => $dsn_info['user'],
    'password' => $dsn_info['pass'],
    'host' => $dsn_info['host'],
    'port' => $dsn_info['port'],
    'driver' => $dsn_info['scheme'],
    'prefix' => '',
    'collation' => 'utf8mb4_general_ci',
  );
}
else {
  $databases['default']['default'] = array (
    'database' => getenv('DATABASE_NAME'),
    'username' => getenv('DATABASE_USER'),
    'password' => getenv('DATABASE_PASSWORD'),
    'host' => getenv('MYSQL_SERVICE_HOST'),
    'port' => 3306,
    'driver' => getenv('DATABASE_ENGINE'),
    'prefix' => '',
    'collation' => 'utf8mb4_general_ci',
  );  
}
