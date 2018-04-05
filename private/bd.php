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
    $pdo->exec("INSERT INTO fight (id_playerOne, id_playerTwo) VALUES ($idPlayerOne, $idPlayerTwo)");
    $select = $pdo->exec("SELECT id FROM fight");
    $fightIds = $select->fetchAll();
    foreach ($fightIds as $fight) {
        $fightId = $fight;
    }
    return $fightId;
}
function kick($attacking, $defending, $fightId) {
    $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a donné un kick à ', $defending, $fightId)");
}
function punch($attacking, $defending, $fightId) {
    $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a punché dans sa face ', $defending, $fightId)");
}
function special($attacking, $defending, $fightId) {
    $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a utilisé son coup spécial sur ', $defending, $fightId)");
}
function win($attacking, $defending, $fightId) {
    $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($attacking, ' a vaincu avec bravoure et panache ', $defending, $fightId)");
}

function resume($fightId) {
    $select = $pdo->exec("SELECT * FROM attack WHERE id = $fightId");
    $combat = $select->fetchAll();
    foreach ($combat as $step) {
        echo "<div>" . $step->attacking . $step->move . $step->defending . "<\div>";
    }
}


/*
Calcul des dommages :

combat1 * $coeffAttack * (intel1 / intel2 + strength1 / strength2 + speed1 / speed2 + durability1 / durability2)

$coeffAttack = rand(0.4,1) pour le kick,
$coeffAttack = rand(0,0.8) pour le punch,
$coeffAttack = rand(0.8,1) pour le special




*/