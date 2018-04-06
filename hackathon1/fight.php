<?php

require_once '../vendor/autoload.php';

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
$perso1 = json_decode($contentPerso1);

// Personnage 2 : requete
$responsePerso2 = $client->request('GET', 'id/10.json');

$body = $responsePerso2->getBody();

$contentPerso2 = $body->getContents();
$perso2 = json_decode($contentPerso2);


$statPower = [
    'Génie' => [$perso1->powerstats->intelligence, $perso2->powerstats->intelligence],
    'Force' => [$perso1->powerstats->strength, $perso2->powerstats->strength],
    'Vitesse' => [$perso1->powerstats->speed, $perso2->powerstats->speed],
    'Endurance' => [$perso1->powerstats->durability, $perso2->powerstats->durability],
    'Puissance' => [$perso1->powerstats->power, $perso2->powerstats->power],
    'Combat'=> [$perso1->powerstats->combat, $perso2->powerstats->combat]
];

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

    <body class="body-fight firebackground">


    <?php include 'header.php'?>

    <div class="container-fluid">
        <div class="body-fight">
            <div class="row">
                <div class="col-md-5 col-md-offset-2 bdr">
                    <h2 class="h2-fight"> <?php echo $perso1->name; ?></h2>
                </div>
                <div class="col-md-2 bdr">
                </div>
                <div class="col-md-5 bdr">
                    <h2 class="h2-fight"> <?php echo $perso2->name; ?> </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 bdr">
                    <h3 class="h3-fight"> Points de vie</h3>
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15"
                             aria-valuemin="0" aria-valuemax="100">15%</div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5 bdr">
                    <h3 class="h3-fight"> Points de vie</h3>
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15"
                             aria-valuemin="0" aria-valuemax="100">15%</div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 bdr btn-attack">
                    <button type="button" class="btn btn-primary btn-lg btn-1">Coup de pied</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-2">Coup de boule</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-3">Boxe-le</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-4">Super attaque</button> <br>
                </div>
                <div class="col-md-3 bdr">
                    <img class="img-fight" src="<?php echo $perso1->images->md; ?>">
                </div>
                <div class="col-md-2 bdr">
                    <img class="img-fight" src="http://www.gifgratis.net/gifs_animes/eclair/10.gif">
                </div>
                <div class="col-md-3 bdr">
                    <img class="img-fight" src="<?php echo $perso2->images->md; ?>">
                </div>
                <div class="col-md-2 bdr btn-attack">
                    <button type="button" class="btn btn-primary btn-lg btn-1">Coup de pied</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-2">Coup de boule</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-3">Boxe-le</button> <br>
                    <button type="button" class="btn btn-primary btn-lg btn-4">Super attaque</button> <br>
                </div>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5 section-fight bdr">
                <h3 class="h3-fight"> Caractéristiques</h3>
            </div>
            <div class="col-md-2 bdr">
            </div>
            <div class="col-md-5 section-fight bdr">
                <h3 class="h3-fight"> Caractéristiques </h3>
            </div>
        </div>




       <?php foreach ($statPower as $attribut => $nbrPoint) {?>
            <div class="row">
                <div class="col-md-1 section-fight bdr">
                    <p> <?php echo $attribut ?></p>
                </div>
                <div class="col-md-4 section-fight bdr">
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $nbrPoint[0] ?>%"
                             aria-valuenow="<?php echo $nbrPoint[0] ?>%"
                             aria-valuemin="0" aria-valuemax="100"><?php echo  $nbrPoint[0] ?>%</div>
                    </div>
                </div>
                <div class="col-md-2 section-no-color bdr">
                    <p></p>
                </div>
                <div class="col-md-1 section-fight bdr">
                    <p><?php echo $attribut ?></p>
                </div>
                <div class="col-md-4 section-fight bdr">
                    <div class="progress PV-fight">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo
                        $nbrPoint[1] ?>%" aria-valuenow="<?php echo
                        $nbrPoint[1] ?>%"
                             aria-valuemin="0" aria-valuemax="100"><?php echo  $nbrPoint[1] ?>%</div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>




    </body>
</html>

