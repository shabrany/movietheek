<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include  __DIR__ . '/lib/start.php';

$orderBy = filter_input(INPUT_GET, FILTER_SANITIZE_STRING);
$movies = get_all_movies($orderBy);

include 'header.php';

?>

<?php if ($config['admin']): ?>
    <div class="row">
        <div class="col-sm-12 text-right">
            <a href="add.php" class="btn btn-primary">new item</a>
        </div>
    </div>
<?php endif ?>
<br>
<h3>My Collection (<?php echo count($movies); ?>)</h3>

<?php if (count($movies)): ?>
    <div class="row">
        <?php foreach ($movies as $movie): ?>
            <?php if ($config['admin']): ?>
                <a href="edit.php?id=<?php echo $movie['id']; ?>">
            <?php endif; ?>

            <article class="col-sm-2" class="dvd-movie">
                <div class="poster">
                    <?php if (strlen($movie['poster']) > 10): ?>
                    <img src="<?php echo $movie['poster']; ?>">
                    <?php endif; ?>
                </div>
                <div class="movie-description">
                    <h4 class="title"><?php echo $movie['title']; ?></h4>
                    <div class="year">(<?php echo $movie['year']; ?>)</div>
                </div>
            </article>

            <?php if ($config['admin']): ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
<?php include 'footer.php'; ?>

