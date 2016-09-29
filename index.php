
<?php 

$dns = 'mysql:host=localhost;dbname=movietheek';
$pdo = new PDO($dns, 'root', 'root');

// sort by 
$order_by = (isset($_GET['order'])) ? $_GET['order'] : 'title';

// get all movies 
$sql = 'SELECT * FROM movies ORDER BY ' . $order_by;

$movies = $pdo->query($sql);

include 'header.php'; ?>

<div class="row">
    <div class="col-sm-12 text-right">
        <a href="add.php" class="btn btn-primary">new item</a>
    </div>
</div>
<br>
<h3>My Collection</h3>

<?php if (count($movies)): ?>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Authors</th>

        </tr>
    
        <?php foreach ($movies as $movie): ?>
            <tr>
                <td><?php echo $movie['id']; ?></td>
                <td><?php echo $movie['title']; ?></td>
                <td><?php echo $movie['authors']; ?></td>                
            </tr>
        <?php endforeach; ?>
    </table>   
<?php endif; ?>

<?php include 'footer.php'; ?>