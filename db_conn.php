<?php
// Require medoo
require_once('Medoo.php');

// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
  'database_type' => 'mysql',
  'database_name' => 'wayfinder_project',
  'server' => 'localhost',
  'username' => 'dev_redoan',
  'password' => 'lynx-friable-afresh',
	 ]);

?>