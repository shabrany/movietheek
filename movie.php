<?php 

$host_api = 'http://www.omdbapi.com/?plot=full&r=json';
$title = (isset($_REQUEST['t'])) ? $_REQUEST['t'] : '';

if (isset($_REQUEST['t'])) { 

    $url = $host_api . '&t=' . urlencode($title);
    $contents = file_get_contents($url);
    $movie = json_decode($contents);

    if (!isset($movie->Error)): ?>
        <div class="movie" 
             data-title="<?php echo $movie->Title; ?>"
             data-year="<?php echo $movie->Year; ?>"
             data-actors="<?php echo $movie->Actors; ?>"
             data-lang="<?php echo $movie->Language; ?>"
             data-poster="<?php echo $movie->Poster; ?>">  
             <?php if ($movie->Poster != 'N/A'): ?>  
            <img src="<?php echo $movie->Poster ?>" height="50">
            <?php endif; ?>
            <span><?php echo $movie->Title; ?> (<?php echo $movie->Year; ?>)</span><br>
            <small><?php echo $movie->Actors; ?></small>
        </div>    
    <?php else: ?>
        <p>Nothing found</p>
    <?php endif; 
}