<?php

define("DSN", "mysql:host=localhost;dbname=hackathon1");
define("USER", "ben");
define("PASS", "benoite");

// Connection
$pdo = new PDO(DSN, USER, PASS);


if (!$pdo) {
    die('error');
}
