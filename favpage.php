<?php 
require_once 'connection.php';
session_start();
//get user id from session 
$userid = 1;
try
{
	$pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e)
{
	throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST['sendfavs'])) {
    $sql = "SELECT favids FROM usertbl WHERE id='{$userid}'";
    $result = $pdo->query($sql);
    while($row=$result->fetch())
    {
        if ($row['favids']=="") 
        {
            echo "<span><br> There are no favorites to be shown </span>";
        }
        else
        {
            $favorites = explode(",", $row['favids']);
           for ($i=0; $i <count($favorites) ; $i++) 
           { 
            $searchapi = 'https://api.themoviedb.org/3/movie/'.$favorites[$i].'?api_key=26f22b6d68c3f93165c8ce3a69b975a4&language=en-US';
            $search_json = file_get_contents($searchapi);
            $decode = json_decode($search_json);
            //$res = $decoded->results;
            echo "<div class=\"img-wrapper\" id=\"{$i}\"><div class=\"img-box\"><img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/{$decode->poster_path}\"/></div> <div class=\"text-box\"><h3>$decode->title</h3><p class=\"date\">$decode->release_date <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"0{$i}\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a{$i}\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : $decode->popularity <br> Original Language :  $decode->original_language <br> Vote Count: $decode->vote_count <br> Average :  $decode->vote_average </span><span class=\"inneroverview\"> Synopsis <br>". addslashes($decode->overview)."</span></p> <input type=\"hidden\" id=\"i{$i}\" value=\"$decode->id\"/></div></div>";
           }

        }
    }
   
}
?>