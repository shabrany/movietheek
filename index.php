<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include  __DIR__ . '/lib/start.php';

// sort by
$orderBy = filter_input(INPUT_GET, FILTER_SANITIZE_STRING);

// get all movies
$movies = get_all_movies($orderBy);

include 'header.php';
?>

<?php if ($config['admin']): ?>
<div class="row">
    <div class="col-sm-12 text-right">
        <a href="add.php" class="btn btn-primary">new item</a>
    </div>
</div>
<br>
<?php endif; ?>

<h3>My Collection (<?php echo count($movies); ?>)</h3>

<?php if (count($movies)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th data-sort-type="integer">ID</th>
                <th>Title</th>
                <th colspan="2">Authors</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?php echo $movie['id']; ?></td>
                    <td><?php echo trim($movie['title']); ?></td>
                    <td><?php echo trim($movie['authors']); ?></td>
                    <td class="text-right">
                        <?php if ($config['admin']): ?>
                            <a href="edit.php?id=<?php echo $movie['id'] ?>" class="btn btn-warning btn-xs">edit</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php include 'footer.php'; ?>
