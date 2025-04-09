<?php
$db_name = getenv("DB_NAME");
$db_host = getenv("DB_HOST");

define("DSN", "mysql:host=$db_host;dbname=$db_name;charset=utf8");

define("USER", "admin_events");
define('PASS', "randomShenanigans!!//??");
