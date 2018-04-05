<?php
require_once '../private/bd.php';
require_once '../vendor/autoload.php';

$querySelect = $pdo->query("SELECT fighter, count(winVS) as victories, count(lostVS) FROM scores GROUP BY fighter ORDER BY victories DESC");
$scores = $querySelect->fetchAll();
$client = new GuzzleHttp\Client([
    'base_uri' => 'https://akabab.github.io/superhero-api/api/'
]);
$fighter = [];
foreach ($scores as $score) {
    $id = $score['fighter'];
    $param = 'id/' . $id . '.json';
    $response = $client->request('GET', $param);
    $body = $response->getBody();
    $json = $body->getContents();
    $fighter = json_decode($json);
    echo $fighter->name . ' a gagné ' . $score['victories'] . ' fois et perdu ' . $score['count(lostVS)'] . ' fois.' . "\n";
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Hall of Fame</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">

</div>
</body>
