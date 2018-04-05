<?php
require_once '../private/bd.php';
require_once '../vendor/autoload.php';

$querySelect = $pdo->query("SELECT fighter, count(winVS) as victories, count(lostVS) FROM scores GROUP BY fighter ORDER BY victories DESC LIMIT 3");
$scores = $querySelect->fetchAll();
$client = new GuzzleHttp\Client([
    'base_uri' => 'https://akabab.github.io/superhero-api/api/'
]);
$fighter = [];
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Hall of Fame</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .allscreen{
        width: 100vw;
        height: 100vh;
    }
    .background{
        background-repeat: no-repeat;
        background-size: 100%;
        background-image: url('images/hall-of-fame.jpg');
    }
</style>
</head>
<body>
<section class="container-fluid image-fluid background allscreen">
    <div class="row align-items-center justify-content-center allscreen">
        <div>
    <?php
    foreach ($scores as $score) {
        $id = $score['fighter'];
        $param = 'id/' . $id . '.json';
        $response = $client->request('GET', $param);
        $body = $response->getBody();
        $json = $body->getContents();
        $fighter = json_decode($json);
        echo '<div>' . $fighter->name . ' a gagné ' . $score['victories'] . ' fois et perdu ' . $score['count(lostVS)'] . ' fois.' . '</div>';
    }
    ?>
        </div>
    </div>
</section>
</body>
