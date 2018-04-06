<?php
session_start();
require_once '../private/bd.php';
require_once '../vendor/autoload.php';
require_once 'class/Fighter.php';


use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://cdn.rawgit.com/akabab/superhero-api/0.2.0/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

if (!empty($_POST)) {
    $fightersID = $_POST;
    $caseID = array_keys($fightersID);
    $_SESSION["idFighter1"] = $caseID[0];
    $_SESSION["idFighter2"] = $caseID[1];

    $query = "INSERT INTO fight(id_playerOne, id_playerTwo) VALUES (" . $caseID[0] . ", " . $caseID[1] . ")";
    $insert = $pdo->exec($query);
    $select = $pdo->query("SELECT id FROM fight");
    $fightIds = $select->fetchAll(PDO::FETCH_OBJ);
    foreach ($fightIds as $fight) {
        $fightId = $fight;
    }
    $fightId = $fightId->id;
}
if(!isset($_SESSION["idFighter2"])){
    header('location:index.php?echec=1');die;
}


// Personnage 1 : requete
$responsePerso1 = $client->request('GET', "id/".$_SESSION["idFighter1"].".json");

$body = $responsePerso1->getBody();

$contentPerso1 = $body->getContents();
$persos1 = json_decode($contentPerso1);

// Personnage 2 : requete
$responsePerso2 = $client->request('GET', "id/".$_SESSION["idFighter2"].".json");

$body = $responsePerso2->getBody();

$contentPerso2 = $body->getContents();
$persos2 = json_decode($contentPerso2);

$fighter1 = new Fighter([
    'id' => $persos1->id,
    'name' => $persos1->name,
    'intelligence' => $persos1->powerstats->intelligence,
    'strength' => $persos1->powerstats->strength,
    'speed' => $persos1->powerstats->speed,
    'durability' => $persos1->powerstats->durability,
    'power' => $persos1->powerstats->power,
    'combat' => $persos1->powerstats->combat,
]);

$fighter2 = new Fighter([
    'id' => $persos2->id,
    'name' => $persos2->name,
    'intelligence' => $persos2->powerstats->intelligence,
    'strength' => $persos2->powerstats->strength,
    'speed' => $persos2->powerstats->speed,
    'durability' => $persos2->powerstats->durability,
    'power' => $persos2->powerstats->power,
    'combat' => $persos2->powerstats->combat,
]);


$button1 = '';
$button2 = '';

if (!empty($_GET['fightId'])) {
    $fightId = $_GET['fightId'];
    $name1 = $fighter1->getName();
    $name2 = $fighter2->getName();
    $id1 = $fighter1->getId();
    $id2 = $fighter2->getId();
}

if (!empty($_GET['power1'])) {
    $fighter1->setPower($_GET['power1']);
}

if (!empty($_GET['power2'])) {
    $fighter2->setPower($_GET['power2']);
}

if (!empty($_GET['kick1'])) {
    $fighter1->kick($fighter2);
    $button1 = 'disabled';
    $button2 = '';
    $query = "INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name1', 'pulverise avec un Kamehameha ', '$name2', $fightId)";
    $insert = $pdo->exec($query);
}

if (!empty($_GET['kick2'])) {
    $fighter2->kick($fighter1);
    $button1 = '';
    $button2 = 'disabled';
    $insert = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name2', 'atomise avec un Kamehameha ', '$name1', $fightId)");
}

if (!empty($_GET['punch1'])) {
    $fighter1->punch($fighter2);
    $button1 = 'disabled';
    $button2 = '';
    $insert = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name1', ' destroy avec un grand Hadoken  ', '$name2', $fightId)");
}

if (!empty($_GET['punch2'])) {
    $fighter2->punch($fighter1);
    $button1 = '';
    $button2 = 'disabled';
    $insert = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name2', ' explose avec un grand Hadoken  ', '$name1', $fightId)");
}

if (!empty($_GET['special1'])) {
    $fighter1->special($fighter2);
    $button1 = 'btn btn-secondary disabled';
    $button2 = 'btn btn-primary';
    $insert = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name1', ' electrise avec son Fatal-Foudre ', '$name2', $fightId)");
}

if (!empty($_GET['special2'])) {
    $fighter2->special($fighter1);
    $button1 = '';
    $button2 = 'disabled';
    $insert = $pdo->exec("INSERT INTO attack(attacking, move, defending, fight_id) VALUES ('$name2', ' defibrile avec son Fatal-Foudre ', '$name1', $fightId)");
}

//WINNER ?
if ($fighter1->getPower() === 0) {

    echo '<p>' . $fighter1->getName() . ' est mort !</p>';
    echo '<p>' . $fighter2->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter1->getId();

    $insert = $pdo->exec("INSERT INTO attack(attacking, move, defending, fight_id) VALUES ('$name2', ' a vaincu avec bravoure et panache ', '$name1', $fightId)");

    header('Location: resume.php?idCombat=' . $fightId . '&idWinner=' . $id2);
    die;

} elseif ($fighter2->getPower() === 0) {

    echo '<p>' . $fighter2->getName() . ' est mort !</p>';
    echo '<p>' . $fighter1->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter2->getId();

    $insert = $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ('$name1', ' a vaincu avec bravoure et panache ', '$name2', $fightId)");

    header('Location: resume.php?idCombat=' . $fightId . '&idWinner=' . $id1);
    die;

} else {
//    echo '<p>Fighter1 : Power : ' . $fighter1->getPower() . '</p>';
//    echo '<p>Fighter2 : Power : ' . $fighter2->getPower() . '</p>';

    $stopFight = 0;
}

/*$boxe = ['Kamehameha','coup2','coup3','coup4','coup5','coup6','coup7','coup8', 'coup9','coup10'];
$selecteBoxe = $boxe[rand(0,9)];
$selecteBoxe1 = $boxe[rand(0,9)];

$kick = ['Hadoken','DoubleKick','coup3','coup4','coup5','coup6','coup7','coup8', 'coup9','coup10'];
$selecteKick = $kick[rand(0,9)];
$selecteKick1 = $kick[rand(0,9)];

$specialHit = ['Fatal-Foudre','Psycho Blast','Borscht Dynamite
','Drago-Rage','Tir de l\'aigle','Landmaster','Peau de banane
','Laser Eyes', 'Force du Jedi','Zidane il a frappé'];
$selecteSpecial = $specialHit[rand(0,9)];
$selecteSpecial1 = $specialHit[rand(0,9)]*/






?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
        <meta charset="utf-8" >
        <title>La wild Arena</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="fire">

    <?php include 'header.php'?>

    <div class="container-fluid">
           <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h2-fight"> <?php echo $persos1->name; ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 bdr">
                            <h3 class="h3-fight"> Points de vie</h3>
                            <div class="progress PV-fight">
                                <div class="progress-bar progress-bar-life" role="progressbar" style="width: <?=$fighter1->getPower() ?>%;"
                                     aria-valuenow=" <?= $fighter1->getPower() ?>"
                                     aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getPower() ?>%</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 bdr btn-attack">
                            <button type="submit" form="kick1"  name="kick1" class="btn btn-primary btn-lg btn-1 btn-hit"
                                    value="1" <?= $button1 ?>>Kamehameha</button>
                            <button type="submit" form="punch1"  name="punch1" class="btn btn-primary btn-lg btn-2 btn-hit"
                                    value="3"
                                <?= $button1 ?>>Hadoken</button> <br>
                            <button type="submit" form="special1"  name="special1" class="btn btn-primary btn-lg btn-3 btn-hit"
                            value="5" <?= $button1 ?>>Fatal-Foudre</button> <br>
                        </div>
                        <div class="col-md-5 bdr">
                            <img class="img-fight" src="<?php echo $persos1->images->md; ?>">
                        </div>
                        <div class="col-md-1 bdr">
                            <img src="http://www.gifgratis.net/gifs_animes/eclair/10.gif" height="300px">
                        </div>
                    </div>
                </div>
                

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h2-fight"> <?php echo $persos2->name; ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 bdr">
                            <h3 class="h3-fight"> Points de vie</h3>
                            <div class="progress PV-fight">
                                <div class="progress-bar progress-bar-life" role="progressbar" style="width: <?=
                                $fighter2->getPower() ?>%;"
                                     aria-valuenow=" <?= $fighter2->getPower() ?>"
                                     aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getPower() ?>%</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 offset-md-2 bdr">
                            <img class="img-fight" src="<?php echo $persos2->images->md; ?>">
                        </div>
                        <div class="col-md-2 bdr btn-attack">
                            <button type="submit" form="kick2" name="kick2" class="btn btn-primary btn-lg btn-1 btn-hit"
                                    value="2"
                                <?= $button2 ?>>Kamehameha</button> <br>
                            <button type="submit" form="punch2" name="punch2" class="btn btn-primary btn-lg btn-2 btn-hit"
                                    value="4"
                            <?= $button2 ?>>Hadoken</button> <br>
                            <button type="submit" form="special2" name="special2" class="btn btn-primary btn-lg btn-2 btn-hit"
                            value="6" <?= $button2 ?>>Fatal-Foudre</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 section-fight bdr-speciality-top bdr">
                            <h3 class="h3-fight"> Caractéristiques</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 offset-md-1 ">
                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> INT </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-intelligence " role="progressbar" style="width: <?=
                                        $fighter1->getIntelligence() ?>%"
                                             aria-valuenow="<?= $fighter1->getIntelligence() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getIntelligence() ?>%
                                        </div>
                                     </div>
                                 </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> STR </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight  ">
                                        <div class="progress-bar progress-bar-strength " role="progressbar" style="width: <?=
                                        $fighter1->getStrength()
                                        ?>%"
                                             aria-valuenow="<?= $fighter1->getStrength() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getStrength() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> SPD </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-speed " role="progressbar" style="width: <?=
                                        $fighter1->getSpeed()
                                        ?>%"
                                             aria-valuenow="<?= $fighter1->getSpeed() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getSpeed() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> DUR </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-durability" role="progressbar" style="width: <?=
                                        $fighter1->getDurability()
                                        ?>%"
                                             aria-valuenow="<?= $fighter1->getDurability() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getDurability() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr-speciality-bottom-left bdr text-center">
                                    <p> CMB </p>
                                </div>
                                <div class="col-md-10 section-fight bdr-speciality-bottom bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-combat" role="progressbar" style="width: <?=
                                        $fighter1->getCombat()
                                        ?>%"
                                             aria-valuenow="<?= $fighter1->getCombat() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getCombat() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 section-fight bdr-speciality-top bdr">
                            <h3 class="h3-fight"> Caractéristiques</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> INT </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-intelligence" role="progressbar" style="width: <?=
                                        $fighter2->getIntelligence() ?>%"
                                             aria-valuenow="<?= $fighter2->getIntelligence() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getIntelligence() ?>%
                                        </div>
                                     </div>
                                 </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> STR </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-strength" role="progressbar" style="width: <?= $fighter2->getStrength()
                                        ?>%"
                                             aria-valuenow="<?= $fighter2->getStrength() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getStrength() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> SPD </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-speed" role="progressbar" style="width: <?=
                                        $fighter2->getSpeed()
                                        ?>%"
                                             aria-valuenow="<?= $fighter2->getSpeed() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getSpeed() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr text-center">
                                    <p> DUR </p>
                                </div>
                                <div class="col-md-10 section-fight bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-durability" role="progressbar" style="width: <?=
                                        $fighter2->getDurability()
                                        ?>%"
                                             aria-valuenow="<?= $fighter2->getDurability() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getDurability() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 section-fight bdr-speciality-bottom-left bdr text-center">
                                    <p> CMB </p>
                                </div>
                                <div class="col-md-10 section-fight bdr-speciality-bottom bdr">
                                    <div class="progress PV-fight ">
                                        <div class="progress-bar progress-bar-combat" role="progressbar" style="width: <?=
                                        $fighter2->getCombat()
                                        ?>%"
                                             aria-valuenow="<?= $fighter2->getCombat() ?>%"
                                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getCombat() ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <br>
        <div class="col-md-4 btn-change-perso">
            <a href="index.php"><h2 class="h2-header link-menu"> Changer vos personnages </h2></a>
        </div>
        <audio src="music/Mortal%20Kombat%20Theme%20Song%20Original.mp3" autoplay loop></audio>


    <?php
    if ($stopFight == 0) {
        ?>

        <form action="" method="get" id="kick1">

            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>


        <form action="" method="get" id="kick2">       
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>


        <form action="" method="get" id="punch1">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>


        <form action="" method="get" id="punch2">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>


        <form action="" method="get" id="special1">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>


        <form action="" method="get" id="special2">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>">
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>">
            <input type="hidden" name="fightId" value="<?= $fightId ?>">
        </form>

        <?php
    }
    ?>
    </div>

    </body>
</html>

