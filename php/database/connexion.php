<?php

require_once __DIR__ . "/config.php";

try {
    $pdo = new PDO(DSN, USER, PASS);
} catch (PDOException $o) {
    echo "Error: " . $o->getMessage();
}