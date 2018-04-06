<?php

require_once ('../vendor/autoload.php');
require_once ('../private/bd.php');
use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://cdn.rawgit.com/akabab/superhero-api/0.2.0/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

if (!empty($_GET['idWinner'])) {

    // Personnage 1 : requete
    $responsePerso1 = $client->request('GET', "id/".$_GET['idWinner'].".json");

    $body = $responsePerso1->getBody();

    $contentPerso1 = $body->getContents();
    $perso1 = json_decode($contentPerso1);

// Personnage 2 : requete
//    $responsePerso2 = $client->request('GET', 'id/10.json');
//
//    $body = $responsePerso2->getBody();
//
//    $contentPerso2 = $body->getContents();
//    $perso2 = json_decode($contentPerso2);

}



?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fightersdex</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <?php include 'header.php'?>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <p class="display-5"><?= $perso1->name ?> est le vainqueur !</p>
                    <img class="img-fight" src="<?php echo $perso1->images->md; ?>">
                    <h2 class="text-center h2-winner">Resumé du combat</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 bdr"></div>
                <div class="col-md-6">

                    <?php if(isset($_GET['idCombat'])) {
                    $idCombat = intval($_GET['idCombat']);
                    $query = "SELECT * FROM attack WHERE fight_id = $idCombat";
                    $select = $pdo->query($query);
                    $combat = $select->fetchAll();
                    ?>
                    <?php
                        foreach ($combat as $step) {?>
                            <p class="p-resume"><?= $step['attacking'] . ' ' . $step['move'] . ' ' .
                                $step['defending']?></p>
                              <?php
                            }
                        }?>

                </div>
            </div>
        </div>

    <a href="index.php" class="btn btn-primary">Retour choix des combattants</a>




        <div id="scrollUp">
            <a href="#top"><img src="Images/to_top.png"/></a>
        </div>


        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="script.js"></script>

    </body>

</html>
