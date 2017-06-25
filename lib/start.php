<?php

require __DIR__ . '/DatabaseManager.php';
require __DIR__ . '/functions.php';

$config = require __DIR__ . '/../config.php';


DB::setConfig('host', 'localhost');
DB::setConfig('username', $config['dbuser']);
DB::setConfig('password', $config['dbpass']);
DB::setConfig('dbname', $config['dbname']);
