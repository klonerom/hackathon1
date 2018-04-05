<?php

require_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://akabab.github.io/superhero-api/api/']);
$id = 1; //334


$response = $client->request('GET', 'id/' . $id . '.json');

$body = $response->getBody();
$contents = $body->getContents();
$persos = json_decode($contents);

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>WildFighter</title>
    </head>
    <body>

    <!-- Button trigger modal -->

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong"
                name="modal" value="1">
            Launch demo modal
        </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: <?php
            if ($persos->appearance->gender  == 'Male'){
                echo "#33f9ff";
            } else {
                echo "#ff33f9";
            }
            ?>">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLongTitle"><?php echo $persos->name ?></h2>
                </div>
                <div class="modal-body">
                    <div class="row d-flex">
                        <div class="col-md-4 d-flex align-items-center">
                            <img class="rounded " src="<?php echo $persos->images->sm ?>">
                        </div>
                        <div class="col-md-8">
                            <h6>Intelligence</h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->intelligence
                                ?>%"></div>
                            </div>
                            <h6>Force</h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->strength
                                ?>%"></div>
                            </div>
                            <h6>Vitesse</h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->speed
                                ?>%"></div>
                            </div>
                            <h6>Resistence</h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->durability
                                ?>%"></div>
                            </div>
                            <h6>Pouvoir</h6>
                            <div class="progress">

                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->power
                                ?>%"></div>
                            </div>
                            <h6>Combat</h6>
                            <div class="progress">

                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo $persos->powerstats->combat
                                ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center h4-modalTitle">Pedigré</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <h6 class="p-pedigree">Taille</h6>
                            <h6 class="p-pedigree">Poid</h6>
                            <h6 class="p-pedigree">Sexe</h6>
                        </div>
                        <div class="col-2">
                            <h6><?php echo $persos->appearance->height[1] ?></h6>
                            <h6><?php echo $persos->appearance->weight[1] ?></h6>
                            <h6><?php echo $persos->appearance->gender ?></h6>
                        </div>
                        <div class="col-5">
                            <h6 class="p-pedigree">Couleur des yeux</h6>
                            <h6 class="p-pedigree">Couleur des cheveux</h6>
                            <h6 class="p-pedigree">Alias</h6>
                        </div>
                        <div class="col-3">
                            <h6><?php echo $persos->appearance->eyeColor ?></h6>
                            <h6><?php echo $persos->appearance->hairColor ?></h6>
                            <h6><?php echo $persos->biography->aliases[0] ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center h4-modalTitle">Stat</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>