<?php 

$host_api = 'http://www.omdbapi.com/?plot=full&r=json';
$imdbID = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : '';

function printJSON($data, $json = false) {
    header('Content-Type: application/json');
    echo (($json) ? json_encode($data) : $data) ;
}

if (!empty($imdbID)) { 
    $url = $host_api . '&i=' . urlencode($imdbID);
    $contents = file_get_contents($url);
    printJSON($contents);
   
} else {
    printJSON(['message' => 'Bad request.'], true);
}