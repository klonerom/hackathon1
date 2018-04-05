<?php

define("DSN", "mysql:host=localhost;dbname=hackathon1");
define("USER", "root");
define("PASS", "jecode4wcs");

// Connection
$pdo = new PDO(DSN, USER, PASS);


if (!$pdo) {
    die('error');
}

function startFight($idPlayerOne, $idPlayerTwo) {
    $insert = $pdo->exec("INSERT INTO fight (id_playerOne, id_playerTwo) VALUES ($idPlayerOne, $idPlayerTwo)");
    $select = $pdo->exec("SELECT id FROM fight");
    $fightIds = $select->fetchAll();
    foreach ($fightIds as $fight) {
        $fightId = $fight;
    }
    return $fightId;
}
function kick($attacking, $defending, $fightId) {
    $querySelect = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a donné un kick à ', $defending, $fightId)");
}
function punch($attacking, $defending, $fightId) {
    $querySelect = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a punché dans sa face ', $defending, $fightId)");
}
function special($attacking, $defending, $fightId) {
    $querySelect = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a utilisé son coup spécial sur ', $defending, $fightId)");
}
function win($attacking, $defending, $fightId) {
    $querySelect = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a vaincu avec bravoure et panache ', $defending, $fightId)");
}