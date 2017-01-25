
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dns = 'mysql:host=localhost;dbname=movietheek';
$pdo = new PDO($dns, 'root', 'root');

// sort by
$order_by = (isset($_GET['order'])) ? $_GET['order'] : 'title';

// get all movies
$sql = 'SELECT * FROM movies ORDER BY ' . $order_by;
$movies = $pdo->query($sql)->fetchAll();

if (filter_input(INPUT_GET, 'output') == 'plain') {

    $i = 1;
    foreach ($movies as $movie) {
        echo $i . "&nbsp;&nbsp;&nbsp;   " . trim($movie['title']); 
        echo (!empty($movie['year'])) ? ' (' . $movie['year'] . ')' : '';       
        echo "<br>"; 
        $i++;
    }

    exit;
}

include 'header.php'; ?>

<div class="row">
    <div class="col-sm-12 text-right">
        <a href="add.php" class="btn btn-primary">new item</a>
    </div>
</div>
<br>
<h3>My Collection (<?php echo count($movies); ?>)</h3>

<?php if (count($movies)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th data-sort-type="integer">ID</th>
                <th>Title</th>
                <th>Authors</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?php echo $movie['id']; ?></td>
                    <td><?php echo trim($movie['title']); ?></td>
                    <td><?php echo trim($movie['authors']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php include 'footer.php'; ?>
