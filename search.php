<?php
$host_api = 'http://www.omdbapi.com/?plot=full&r=json';
$title = filter_input(INPUT_GET, 's', FILTER_SANITIZE_ENCODED);
$page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT, ['options' => ['default' => 1]]);
$movies = [];
$query_string = '';

if ($title) {
	$query_string = '&s=' . $title . '&page=' . $page;
	$url = $host_api . $query_string;
    $contents = file_get_contents($url);
    $movies = json_decode($contents);
}
?>

<?php if ($movies->Response == 'True'): ?>

	<?php $totalPages = round($movies->totalResults / 10); ?>

	<div class="result-info">
		<ul class="list-inline">
			<li>Found: <span class="badge"><?php echo $movies->totalResults; ?></span></li>
			<li>Page <?php echo $page; ?> of <?php echo $totalPages; ?></li>
		</ul>
	</div>

	<?php foreach ($movies->Search as $movie): ?>
		<div class="movie"
			data-title="<?php echo $movie->Title; ?>"
			data-imdb="<?php echo $movie->imdbID; ?>">
			<?php if ($movie->Poster != 'N/A'): ?>
				<img src="<?php echo $movie->Poster ?>" height="80">
			<?php endif; ?>
			<span><?php echo $movie->Title; ?> (<?php echo $movie->Year; ?>)</span>
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
		<span><?php echo $movies->Error; ?></span>
	</div>
<?php endif; ?>

