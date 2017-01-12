<?php 

$host_api = 'http://www.omdbapi.com/?plot=full&r=json';

$title = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

$movies = [];

if ($title) {
	$url = $host_api . '&s=' . urlencode($title);
    $contents = file_get_contents($url);
    $movies = json_decode($contents);
}
?>

<?php if ($movies->Response): ?>

	<?php foreach ($movies->Search as $movie): ?>		

		<div class="movie" 
			data-title="<?php echo $movie->Title; ?>"
			data-imdb="<?php echo $movie->imdbID; ?>"
			data-poster="<?php echo $movie->Poster; ?>">
			<?php if ($movie->Poster != 'N/A'): ?>  
				<img src="<?php echo $movie->Poster ?>" height="80">
			<?php endif; ?>
			<span><?php echo $movie->Title; ?> (<?php echo $movie->Year; ?>)</span>
		</div>   

	<?php endforeach; ?>

<?php endif; ?>
