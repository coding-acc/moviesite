<?php
if (isset($_POST['search'])) {
    $userval = $_POST['search'];
    $userval2 = strtolower(preg_replace("/[^A-Za-z0-9]/",'',$userval));
    $searchmovies = 'https://api.themoviedb.org/3/search/movie?api_key=26f22b6d68c3f93165c8ce3a69b975a4&language=en-US&query='.$userval2.'&page=1&include_adult=false';
    $searchres_json = file_get_contents($searchmovies);
    $decoded = json_decode($searchres_json);
    $result = $decoded->results;
    //echo "<script> console.log(\"{$result[0]->title}\");</script>";
    for($i=0;$i<5;$i++)
    {
        echo "<li> {$result[$i]->title}</li>";
    }
   
}
?>