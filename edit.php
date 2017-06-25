<?php

require __DIR__ . '/lib/start.php';

if (!$config['admin']) {
	header('Location: index.php');
}

include 'header.php';

update_movie_on_post();

// Get movie
$movie_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$movie = get_movie($movie_id);

?>

<h3>Insert new item</h3>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="id" value="<?php echo $movie_id; ?>">
	<input type="hidden" name="poster" value="<?php echo (isset($_POST['poster'])) ? $_POST['poster'] : $movie['poster']; ?>">


	<div class="row">

		<div class="col-sm-8">

			 <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" id="title" class="form-control" value="<?php echo isset($_POST['title']) ? $_POST['title'] : $movie['title']; ?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>IMDB ID</label>
						<input type="text" name="imdb" id="imdb" class="form-control" value="<?php echo isset($_POST['imdb']) ? $_POST['imdb'] : $movie['imdb_id']; ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Subtitle</label>
				<input type="text" name="subtitle" class="form-control" value="<?php echo isset($_POST['subtitle']) ? $_POST['subtitle'] : $movie['subtitle']; ?>">
			</div>

			<div class="form-group">
				<label>Authors</label>
				<input type="text" name="authors" class="form-control" value="<?php echo isset($_POST['authors']) ? $_POST['authors'] : $movie['authors']; ?>">
			</div>

			<div class="form-group">
				<label>Year</label>
				<input type="text" name="year" class="form-control" value="<?php echo isset($_POST['year']) ? $_POST['year'] : $movie['year']; ?>">
			</div>

			<div class="form-group">
				<label>Language code</label>
				<input type="text" name="lang_code" class="form-control" value="<?php echo isset($_POST['lang_code']) ? $_POST['lang_code'] : $movie['languages']; ?>">
			</div>

			<div class="form-group">
				<div class="checkbox">
					<label>
						<?php $checked = ($movie['wishlist'] == 1) ? 'checked' : ''; ?>
						<input type="checkbox" value="1" name="wishlist" <?php echo $checked; ?>> Check me out
					</label>
				</div>
			</div>

		</div>

		<div class="col-sm-4">

			<div class="image-wrapper">
				<?php if (!empty($movie['poster'])): ?>
					<img src="<?php echo $movie['poster'] ?>" alt="<?php echo $movie['title']; ?>">
				<?php endif; ?>
			</div>

		</div>

	</div>

	<div class="form-group">
		<input type="submit" name="submit" class="btn btn-success">
	</div>
</form>

<script type="text/javascript" src="js/movie-picker.js"></script>

<?php include 'footer.php'; ?>
