<?php
$config = require __DIR__ . '/config.php';

if (!$config['admin']) {
    die('No access for you my friend');
}

$api_url = 'https://api.themoviedb.org/3/movie';
$api_image_url = 'https://image.tmdb.org/t/p/w500';

$movie_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

function printJSON($data, $json = false) {
    header('Content-Type: application/json');
    echo (($json) ? json_encode($data) : $data) ;
}

if (!empty($movie_id)) {
    $url = $api_url . '/' . $movie_id . '?' . http_build_query([
    	'api_key' => $config['api_key']
    	//'append_to_response' => 'people,credits'
    ]);
    $movie = json_decode(file_get_contents($url));
    $movie->poster_path = $api_image_url . $movie->poster_path;
    printJSON($movie, true);
} else {
    printJSON(['message' => 'Bad request.'], true);
}
