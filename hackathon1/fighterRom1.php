
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<?php

require_once '../vendor/autoload.php';
require_once 'class/Fighter.php';


// Create a client with a base URI
$client = new GuzzleHttp\Client([
        'base_uri' => 'https://akabab.github.io/superhero-api/api/',
    ]
);

// PERSO 1
//------------------
// Send a request to https://foo.com/api/test
$response1 = $client->request('GET', 'id/2.json');


//Afficher une response
$body1 = $response1->getBody();
$contents1 = $body1->getContents();
$persos1 = json_decode($contents1);

//var_dump($persos1->name);

// PERSO 2
//------------------
// Send a request to https://foo.com/api/test
$response2 = $client->request('GET', 'id/3.json');


//Afficher une response
$body2 = $response2->getBody();
$contents2 = $body2->getContents();
$persos2 = json_decode($contents2);

//var_dump($persos2->name);


//Test
//----------
$fighter1 = new Fighter([
    'id' => $persos1->id,
    'name' => $persos1->name,
    'intelligence' => $persos1->powerstats->intelligence,
    'power' => $persos1->powerstats->power,
]);

$fighter2 = new Fighter([
    'id' => $persos2->id,
    'name' => $persos2->name,
    'intelligence' => $persos2->powerstats->intelligence,
    'power' => $persos2->powerstats->power,
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
    echo 'kick1';
    $fighter1->kick($fighter2);
    $button1 = 'disabled';
    $button2 = '';
}

if (!empty($_GET['kick2'])) {
    echo 'kick2';
    $fighter2->kick($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}

if (!empty($_GET['punch1'])) {
    echo 'punch1';
    $fighter1->punch($fighter2);
    $button1 = 'disabled';
    $button2 = '';
}

if (!empty($_GET['punch2'])) {
    echo 'punch2';
    $fighter2->punch($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}

if (!empty($_GET['special1'])) {
    echo 'special1';
    $fighter1->special($fighter2);
    $button1 = 'btn btn-secondary disabled';
    $button2 = 'btn btn-primary';
}

if (!empty($_GET['special2'])) {
    echo 'special2';
    $fighter2->special($fighter1);
    $button1 = '';
    $button2 = 'disabled';
}


//WINNER ?
if ($fighter1->getPower() === 0) {

    echo '<p>' . $fighter1->getName() . ' est mort !</p>';
    echo '<p>' . $fighter2->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter1->getId();

} elseif ($fighter2->getPower() === 0) {

    echo '<p>' . $fighter2->getName() . ' est mort !</p>';
    echo '<p>' . $fighter1->getName() . ' is the WINNER !</p>';

    $stopFight = $fighter2->getId();

} else {
    echo '<p>Fighter1 : Power : ' . $fighter1->getPower() . '</p>';
    echo '<p>Fighter2 : Power : ' . $fighter2->getPower() . '</p>';

    $stopFight = 0;
}

?>

<?php
if ($stopFight == 0) {
?>

<form action="" method="get" id="kick1">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="kick1"  name="kick1" value="1" <?= $button1 ?>>kick1</button>

<form action="" method="get" id="kick2">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="kick2" name="kick2" value="2" <?= $button2 ?>>kick2</button>

<form action="" method="get" id="punch1">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="punch1"  name="punch1" value="3" <?= $button1 ?>>punch1</button>

<form action="" method="get" id="punch2">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="punch2" name="punch2" value="4" <?= $button2 ?>>punch2</button>

<form action="" method="get" id="special1">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="special1"  name="special1" value="5" <?= $button1 ?>>special1</button>

<form action="" method="get" id="special2">
    power1: <input type="text" name="power1" value="<?= $fighter1->getPower() ?>"><br>
    power2: <input type="text" name="power2" value="<?= $fighter2->getPower() ?>"><br>
</form>

<button type="submit" form="special2" name="special2" value="4" <?= $button2 ?>>special2</button>
<?php
}
?>
