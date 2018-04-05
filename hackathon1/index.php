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
                            <a href="#" class="btn btn-primary btn-card">Go somewhere</a>
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
    </div>


    <div id="scrollUp">
        <a href="#top"><img src="Images/to_top.png"/></a>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="script.js"></script>


</body>

</html>