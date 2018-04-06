<?php

require_once '../vendor/autoload.php';
require_once 'class/Fighter.php';

use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://cdn.rawgit.com/akabab/superhero-api/0.2.0/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

// Personnage 1 : requete
$responsePerso1 = $client->request('GET', 'id/56.json');

$body = $responsePerso1->getBody();

$contentPerso1 = $body->getContents();
$persos1 = json_decode($contentPerso1);

// Personnage 2 : requete
$responsePerso2 = $client->request('GET', 'id/10.json');

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
}

if (!empty($_GET['kick2'])) {
    $fighter2->kick($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}

if (!empty($_GET['punch1'])) {
    $fighter1->punch($fighter2);
    $button1 = 'disabled';
    $button2 = '';
}

if (!empty($_GET['punch2'])) {
    $fighter2->punch($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}

if (!empty($_GET['special1'])) {
    $fighter1->special($fighter2);
    $button1 = 'btn btn-secondary disabled';
    $button2 = 'btn btn-primary';
}

if (!empty($_GET['special2'])) {
    $fighter2->special($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}


//WINNER ?
if ($fighter1->getPower() === 0) {

    echo '<p>' . $fighter1->getName() . ' est mort !</p>';
    echo '<p>' . $fighter2->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter1->getId();

    header('Location: resume.php?idCombat=1&idWinner=' . $fighter2->getId());
    die;

} elseif ($fighter2->getPower() === 0) {

    echo '<p>' . $fighter2->getName() . ' est mort !</p>';
    echo '<p>' . $fighter1->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter2->getId();

    header('Location: resume.php?idCombat=1&idWinner=' . $fighter1->getId());
    die;

} else {
//    echo '<p>Fighter1 : Power : ' . $fighter1->getPower() . '</p>';
//    echo '<p>Fighter2 : Power : ' . $fighter2->getPower() . '</p>';

    $stopFight = 0;
}

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

    <body class="body-fight">


    <?php include 'header.php'?>

    <div class="container-fluid">
        <div class="body-fight">
            <div class="row">
                <div class="col-md-5 col-md-offset-2 bdr">
                    <h2 class="h2-fight"> <?php echo $persos1->name; ?></h2>
                </div>
                <div class="col-md-2 bdr">
                </div>
                <div class="col-md-5 bdr">
                    <h2 class="h2-fight"> <?php echo $persos2->name; ?> </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 bdr">
                    <h3 class="h3-fight"> Points de vie</h3>
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: <?= $fighter1->getPower() ?>%;"
                             aria-valuenow=" <?= $fighter1->getPower() ?>"
                             aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getPower() ?>%</div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5 bdr">
                    <h3 class="h3-fight"> Points de vie</h3>
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: <?= $fighter2->getPower() ?>%;" aria-valuenow="<?= $fighter2->getPower() ?>"
                             aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getPower() ?>%</div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 bdr btn-attack">
                    <button type="submit" form="kick1"  name="kick1" class="btn btn-primary btn-lg btn-1" value="1" <?= $button1 ?>>Kamehameha</button>
                    <button type="submit" form="punch1"  name="punch1" class="btn btn-primary btn-lg btn-2" value="3"
                        <?= $button1 ?>>Hadoken</button> <br>
                    <button type="submit" form="special1"  name="special1" class="btn btn-primary btn-lg btn-3"
                            value="5" <?= $button1 ?>>Fatal-Foudre</button> <br>
                </div>
                <div class="col-md-3 bdr">
                    <img class="img-fight" src="<?php echo $persos1->images->md; ?>">
                </div>
                <div class="col-md-2 bdr">
                    <img class="img-fight" src="http://www.gifgratis.net/gifs_animes/eclair/10.gif">
                </div>
                <div class="col-md-3 bdr">
                    <img class="img-fight" src="<?php echo $persos2->images->md; ?>">
                </div>
                <div class="col-md-2 bdr btn-attack">
                    <button type="submit" form="kick2" name="kick2" class="btn btn-primary btn-lg btn-1" value="2"
                        <?= $button2 ?>>Kamehameha</button> <br>
                    <button type="submit" form="punch2" name="punch2" class="btn btn-primary btn-lg btn-2" value="4"
                    <?= $button2 ?>>Hadoken</button> <br>
                    <button type="submit" form="special2" name="special2" class="btn btn-primary btn-lg btn-2"
                            value="6" <?= $button2 ?>>Fatal-Foudre</button>
                    <br>
                </div>

            </div>
        </div>
        <br>

        <div class="row">

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8 offset-md-2 section-fight bdr">
                        <h3 class="h3-fight"> Caractéristiques</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-2 section-fight bdr text-center">
                                <p> INT </p>
                            </div>
                            <div class="col-md-10 section-fight bdr">
                                <div class="progress PV-fight ">
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter1->getIntelligence() ?>%"
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
                                <div class="progress PV-fight ">
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter1->getStrength()
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
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter1->getSpeed()
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
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter1->getDurability()
                                    ?>%"
                                         aria-valuenow="<?= $fighter1->getDurability() ?>%"
                                         aria-valuemin="0" aria-valuemax="100"><?= $fighter1->getDurability() ?>%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 section-fight bdr text-center">
                                <p> CMB </p>
                            </div>
                            <div class="col-md-10 section-fight bdr">
                                <div class="progress PV-fight ">
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter1->getCombat()
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
                    <div class="col-md-8 offset-md-2 section-fight bdr">
                        <h3 class="h3-fight"> Caractéristiques</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-2 section-fight bdr text-center">
                                <p> INT </p>
                            </div>
                            <div class="col-md-10 section-fight bdr">
                                <div class="progress PV-fight ">
                                    <div class="progress-bar " role="progressbar" style="width: <?=
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
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter2->getStrength()
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
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter2->getSpeed()
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
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter2->getDurability()
                                    ?>%"
                                         aria-valuenow="<?= $fighter2->getDurability() ?>%"
                                         aria-valuemin="0" aria-valuemax="100"><?= $fighter2->getDurability() ?>%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 section-fight bdr text-center">
                                <p> CMB </p>
                            </div>
                            <div class="col-md-10 section-fight bdr">
                                <div class="progress PV-fight ">
                                    <div class="progress-bar " role="progressbar" style="width: <?= $fighter2->getCombat()
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


    <?php
    if ($stopFight == 0) {
        ?>

        <form action="" method="get" id="kick1">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>


        <form action="" method="get" id="kick2">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>


        <form action="" method="get" id="punch1">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>


        <form action="" method="get" id="punch2">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>


        <form action="" method="get" id="special1">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>


        <form action="" method="get" id="special2">
            <input type="hidden" name="power1" value="<?= $fighter1->getPower() ?>"><br>
            <input type="hidden" name="power2" value="<?= $fighter2->getPower() ?>"><br>
        </form>

        <?php
    }
    ?>
    </div>

    </body>
</html>

