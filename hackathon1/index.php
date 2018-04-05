<?php


var_dump($_POST);

require_once ('../vendor/autoload.php');
use GuzzleHttp\Client;
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://cdn.rawgit.com/akabab/superhero-api/0.2.0/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
$response = $client->request('GET', 'all.json');
$body = $response->getBody();
$characters = json_decode($body);

//modal

if (isset($_POST['modal'])) {
    var_dump($_POST);
    $id = $_POST['modal']; //334

    $response_modal = $client->request('GET', 'id/' . $id . '.json');
    $body_modal = $response_modal->getBody();
    $contents = $body_modal->getContents();
    $persos = json_decode($contents);
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
    <div class="container">
        <form action="index.php" method="post">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Fightersdex</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12  text-center p-3">
                    <button type="submit" class="btn btn-primary">Fight</button>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($characters as $character) {
                ?>
                <div class="col-md-2 col-sm-6 text-center m-3">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $character->images->sm; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $character->name; ?></h5>
                            <button type="button" class="btn btn-primary btn-card" data-toggle="modal"
                                    data-target="#exampleModalLong" name="modal" value="<?php echo $character->id?>">
                                Description
                            </button>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="<?php echo $character->id?>" id="<?php echo $character->id?>">
                                <label class="custom-control-label" for="<?php echo $character->id ?>"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>
            </div>
        </form>

        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: <?php
                if ($persos->appearance->gender  == 'Male'){
                    echo "#a4fde9";
                } else {
                    echo "#f7c7f9";
                }
                ?>">
                    <div class="modal-header">
                        <h2 class="modal-title text-center" id="exampleModalLongTitle"><?php if(isset($persos)) { echo
                            $persos->name; }?></h2>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex">
                            <div class="col-md-4 d-flex align-items-center">
                                <img class="rounded " src="<?php if(isset($persos)) { echo $persos->images->sm; } ?>">
                            </div>
                            <div class="col-md-8">
                                <h6>Intelligence</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-intelligence" role="progressbar"
                                         aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php echo $persos->powerstats->intelligence
                                    ?>%"></div>
                                </div>
                                <h6>Force</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-strength" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php if(isset($persos)) {echo
                                    $persos->powerstats->strength; }
                                    ?>%"></div>
                                </div>
                                <h6>Vitesse</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-speed" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php echo $persos->powerstats->speed
                                    ?>%"></div>
                                </div>
                                <h6>Resistence</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-durability" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php if(isset($persos)) { echo
                                    $persos->powerstats->durability; }
                                    ?>%"></div>
                                </div>
                                <h6>Pouvoir</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-power" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php if(isset($persos)) { echo
                                    $persos->powerstats->power; }
                                    ?>%"></div>
                                </div>
                                <h6>Combat</h6>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-combat" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php if(isset($persos)) { echo
                                    $persos->powerstats->combat; }
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
                                <h6><?php if(isset($persos)) { echo $persos->appearance->height[1];} ?></h6>
                                <h6><?php if(isset($persos)) { echo $persos->appearance->weight[1];} ?></h6>
                                <h6><?php if(isset($persos)) { echo $persos->appearance->gender;} ?></h6>
                            </div>
                            <div class="col-5">
                                <h6 class="p-pedigree">Couleur des yeux</h6>
                                <h6 class="p-pedigree">Couleur des cheveux</h6>
                                <h6 class="p-pedigree">Alias</h6>
                            </div>
                            <div class="col-3">
                                <h6><?php if(isset($persos)) { echo $persos->appearance->eyeColor;} ?></h6>
                                <h6><?php if(isset($persos)) { echo $persos->appearance->hairColor;} ?></h6>
                                <h6><?php if(isset($persos)) { echo $persos->biography->aliases[0];} ?></h6>
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
    </div>


    <div id="scrollUp">
        <a href="#top"><img src="Images/to_top.png"/></a>
    </div>




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="script.js"></script>


</body>

</html>
