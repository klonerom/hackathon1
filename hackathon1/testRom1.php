<?php

require_once '../vendor/autoload.php';


// Create a client with a base URI
$client = new GuzzleHttp\Client([
'base_uri' => 'https://akabab.github.io/superhero-api/api/',
]
);

// Send a request to https://foo.com/api/test
$response = $client->request('GET', 'id/2.json');
// or
// Send request https://foo.com/api/test?key=maKey&name=toto
//$response = $client->request('GET', 'id', [
//'key'  => 'maKey',
//'name' => 'toto',
//]
//);

//Afficher une response
$body = $response->getBody();

$contents = $body->getContents();
$persos = json_decode($contents);

var_dump($persos);
//foreach ($persos as $perso) {
//    echo '<p>' . $perso . '</p>';
//}

//echo $persos->biography->fullName;


