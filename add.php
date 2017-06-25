<?php

require __DIR__ . '/lib/start.php';

if (!$config['admin']) {
	header('Location: index.php');
}

include 'header.php';

$message = '';

if (insert_movie_on_post()) {
	$message = 'Movie inserted: ' . $_POST['title'];
	$_POST = null;
}

?>

<h3>Insert new item</h3>

<?php if (!empty($message)): ?>
	<div class="alert alert-success"><?php echo $message; ?></div>
<?php endif ?>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="poster" value="">

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Title</label>
				<input type="text" name="title" id="title" class="form-control" value="<?php isset($_POST['title']) ? $_POST['title'] : ''; ?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>IMDB ID</label>
				<input type="text" name="imdb" id="imdb_id" class="form-control" value="<?php isset($_POST['imdb_id']) ? $_POST['imdb_id'] : ''; ?>">
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>Subtitle</label>
		<input type="text" name="subtitle" class="form-control" value="<?php isset($_POST['subtitle']) ? $_POST['subtitle'] : ''; ?>">
	</div>

	<div class="form-group">
		<label>Authors</label>
		<input type="text" name="authors" class="form-control" value="<?php isset($_POST['authors']) ? $_POST['authors'] : ''; ?>">
	</div>

	<div class="form-group">
		<label>Year</label>
		<input type="text" name="year" class="form-control" value="<?php isset($_POST['year']) ? $_POST['year'] : ''; ?>">
	</div>

	<div class="form-group">
		<label>Language code</label>
		<input type="text" name="languages" class="form-control" value="<?php isset($_POST['languages']) ? $_POST['languages'] : ''; ?>">
	</div>

	 <div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" value="1" name="wishlist"> Check me out
			</label>
		</div>
	</div>

	<div class="form-group">
		<input type="submit" name="submit" class="btn btn-success">
	</div>
</form>

<script type="text/javascript" src="js/movie-picker.js"></script>

<?php include 'footer.php'; ?>
