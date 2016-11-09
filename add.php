<?php 

$dns = 'mysql:host=localhost;dbname=movietheek';
$pdo = new PDO($dns, 'root', 'root');

include 'header.php';

$is_title_valid = (isset($_POST['title']) && !empty($_POST['title']));
$is_year_valid = (isset($_POST['year']) && !empty($_POST['year']));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_title_valid && $is_year_valid)  {

    $sql = 'INSERT INTO movies (title, subtitle, year, authors, languages, wishlist, poster) 
                        VALUES (:title, :subtitle, :year, :authors, :languages, :wishlist, :poster)';

    $wishlist = (isset($_POST['wishlist'])) ? $_POST['wishlist'] : 0;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $_POST['subtitle'], PDO::PARAM_STR);
        $stmt->bindParam(':year', $_POST['year'], PDO::PARAM_INT);
        $stmt->bindParam(':authors', $_POST['authors'], PDO::PARAM_STR);
        $stmt->bindParam(':languages', $_POST['lang_code'], PDO::PARAM_STR);
        $stmt->bindParam(':wishlist', $wishlist, PDO::PARAM_INT);
        $stmt->bindParam(':poster', $_POST['poster'], PDO::PARAM_STR);
        $stmt->execute();

        echo '<p class="bg-success padding">Item added: ' . $_POST['title'] . '</p>';
        $_POST = null;

    } catch (PDOException $e) {
        echo '<p class="bg-danger padding"> 
            Regelnummer: '.$e->getLine().'<br /> 
            Bestand: '.$e->getFile().'<br /> 
            Foutmelding: '.$e->getMessage().' 
        </p>';
    }

} 
?>

<h3>Insert new item</h3>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>"> 
    <input type="hidden" name="poster" value="">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" id="title" class="form-control" value="<?php isset($_POST['title']) ? $_POST['title'] : ''; ?>">
        <div id="ajax-container"></div>
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
        <input type="text" name="lang_code" class="form-control" value="<?php isset($_POST['lang_code']) ? $_POST['lang_code'] : ''; ?>">
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

<script type="text/javascript">
(function() {
    'use strict';

    var input_title = document.getElementById('title'),
        ajax_container = document.getElementById('ajax-container'),
        ENTER_KEY = 13,
        SPACE_BAR_KEY = 32,
        ESCAPE_KEY = 27;

    // Add keyup listener
    input_title.addEventListener('keyup', function(event) {
        if (input_title.value.length < 3 || event.which !== SPACE_BAR_KEY) {
            return false;
        }       

        // create ajax request
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                ajax_container.innerHTML = xhr.responseText;
                ajax_container.style.display = 'block';
            }
        };
        xhr.open('GET', 'movie.php?t=' + encodeURI(input_title.value.trim()), true);
        xhr.send(null);
    });

    document.addEventListener('keyup', function(event) {
        console.log(event.which === ESCAPE_KEY);
        if (event.which === ESCAPE_KEY) {
            ajax_container.style.display = 'none';
        }
    });

    // select movie
    ajax_container.addEventListener('click', function(event) {
         var movie = this.querySelector('.movie');
         document.querySelector('input[name=title]').value = movie.dataset.title;
         document.querySelector('input[name=year]').value = movie.dataset.year;
         document.querySelector('input[name=authors]').value = movie.dataset.actors;
         document.querySelector('input[name=lang_code]').value = movie.dataset.lang;
         document.querySelector('input[name=poster]').value = movie.dataset.poster;
         this.style.display = 'none';
    });    
})();

</script>

<?php include 'footer.php'; ?>