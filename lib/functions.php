<?php

function get_all_movies($orderBy) {
    $query = 'SELECT * FROM movies';
    if (!empty($orderBy)) {
        $query .= ' ORDER BY ' . $orderBy;
    }
    return DB::getInstance()->getResults($query);
}

function get_movie($id) {
    $query = 'SELECT * FROM movies WHERE id = ?';
    return DB::getInstance()->getRow($query, [intval($id)]);
}

function update_movie() {
    $is_title_valid = (isset($_POST['title']) && !empty($_POST['title']));
    $is_year_valid = (isset($_POST['year']) && !empty($_POST['year']));

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_title_valid && $is_year_valid)  {

        $data = filter_input_array(INPUT_POST, [
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'imdb_id' => FILTER_SANITIZE_NUMBER_INT,
            'title' => FILTER_SANITIZE_STRING,
            'subtitle' => FILTER_SANITIZE_STRING,
            'year' => FILTER_SANITIZE_NUMBER_INT,
            'authors' => FILTER_SANITIZE_STRING,
            'languages' => FILTER_SANITIZE_STRING,
            'wishlist' => FILTER_SANITIZE_NUMBER_INT,
            'poster' => FILTER_SANITIZE_STRING
        ]);

        return DB::getInstance()->update('movies', $data);
    }
}
