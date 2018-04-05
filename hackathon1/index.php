<?php

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
//echo $body->getContents();
$characters = json_decode($body);


foreach ($characters as $character) {
    echo $character->name . '<br>'; ?>
    <img src="<?php echo $character->images->xs; ?>"> <br>
<?php
}
?>

