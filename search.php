<?php
$config = require __DIR__ . '/config.php';

if (!$config['admin']) {
	die('No access for you my friend');
}

$api_url = 'https://api.themoviedb.org/3/search/movie';
$api_image_url = 'https://image.tmdb.org/t/p/w500';
$title = filter_input(INPUT_GET, 's', FILTER_SANITIZE_ENCODED);
$page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT, ['options' => ['default' => 1]]);
$movies = [];

if ($title) {
	$url = $api_url . '?'. http_build_query(['api_key' => $config['api_key'], 'query' => $title, 'page' => $page]);
	$contents = file_get_contents($url);
    $movies = json_decode($contents);
}
?>

<?php if ($movies && $movies->total_results > 0): ?>

	<?php $totalPages = $movies->total_pages; ?>

	<div class="result-info">
		<ul class="list-inline">
			<li>Found: <span class="badge"><?php echo $movies->total_results; ?></span></li>
			<li>Page <?php echo $page; ?> of <?php echo $totalPages; ?></li>
		</ul>
	</div>

	<?php foreach ($movies->results as $movie): ?>
		<div class="movie"
			data-title="<?php echo $movie->title; ?>"
			data-imdb="<?php echo $movie->id; ?>">
			<?php if ($movie->poster_path): ?>
				<img src="<?php echo $api_image_url . $movie->poster_path ?>" height="80">
			<?php endif; ?>
			<span><?php echo $movie->title; ?> (<?php echo substr($movie->release_date, 0, 4); ?>)</span>
		</div>
	<?php endforeach; ?>

	<?php if ($totalPages > 1): ?>
		<?php $search_url = 'search.php?s=' . $title; ?>
		<nav aria-label="">
			<ul class="pager">
				<?php if ($page > 1): ?>
					<li><a class="page-nav" data-href="<?php echo $search_url . '&p=' . ($page - 1); ?>">Prev</a></li>
				<?php endif; ?>
				<li><a class="page-nav" data-href="<?php echo $search_url . '&p=' . ($page + 1); ?>">Next</a></li>
			</ul>
		</nav>
	<?php endif; ?>

<?php else: ?>
	<div class="item">
		<span>Nothing found</span>
	</div>
<?php endif; ?>
