<?php

require_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://akabab.github.io/superhero-api/api/']);
$response = $client->request('GET', 'all.json');


$body = $response->getBody();
$contents = $body->getContents();
$images = json_decode($contents);

foreach ($images as $image) {?>
    <img src="<?php echo   $image->images->sm ?>">
    <br>
    <?php
}
?>