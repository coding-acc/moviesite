<?php
require_once 'connection.php';
session_start();

try
{
	$pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e)
{
	throw new PDOException($e->getMessage(), (int)$e->getCode());
}
$_SESSION['loggedin']=true;
/*
if (empty($_POST['fav_id'])) 
{
    echo "empty";
}
else
{
    echo "filled";
    $currentfavs="";
    $_SESSION['favs'][$_SESSION['favcount']];
    $_SESSION['favcount']++;
    $usid = $_SESSION['id'];
    $favs = $_POST['fav_id'];
    echo "<script> var tester = {$favs}; console.log(tester);</script>";
    $sql = "SELECT favids FROM usertbl WHERE id='{$usid}'";
    $r = $pdo->query($sql);
    if ($r->rowCount()) 
    {
        while($row = $r->fetch())
        {
            $currentfavs = $row['favids'].",".$_POST['fav_id'];
            $sqlupdate = "UPDATE usertbl SET favid='{$currentfavs}' WHERE id='{$usid}'";
            $resu = $pdo->query($sqlupdate);
        }
    }
    else
    {
        $sqlupdate = "UPDATE usertbl SET favid='{$_POST['fav_id']}' WHERE id='{$usid}'";
        $resu = $pdo->query($sqlupdate);
    }
    echo $_POST['fav_id'];
}*/


/*
if (!empty($_POST['f'])) {
    echo $_POST['f'];
    $favs = $_POST['f'];
    echo "<script> var tester = {$favs}; console.log(tester);</script>";
}

$json_fav = json_decode(file_get_contents('php://input',true));
$data_fav = json_decode($json_fav);
if (empty($json_fav)) {
    echo"also empty";
}
else
{
echo $json_fav;
}*/


$movies_api = 'https://api.themoviedb.org/3/movie/top_rated?api_key=26f22b6d68c3f93165c8ce3a69b975a4&language=en-US&page=1';
$movies_api2= 'https://api.themoviedb.org/3/movie/top_rated?api_key=26f22b6d68c3f93165c8ce3a69b975a4&language=en-US&page=2';
$movies_api3= 'https://api.themoviedb.org/3/movie/top_rated?api_key=26f22b6d68c3f93165c8ce3a69b975a4&language=en-US&page=3';
$json_cont = file_get_contents($movies_api);
$json_cont2 = file_get_contents($movies_api2);
$json_cont3 = file_get_contents($movies_api3);
$json_decode3 = json_decode($json_cont3);
$json_decode2=json_decode($json_cont2);
$res3 = $json_decode3->results;
$_SESSION['favs']=[];
$_SESSION['favcount']=0;
//print_r($json_cont);
//put into php array
$json_decode = json_decode($json_cont);
$res2 = $json_decode2->results;
//print_r($json_decode->results);
$res = $json_decode->results;

$results = [...$res,...$res2,...$res3];
//print_r(count($result));
//print_r($results[0]);
/* Create a user table in database  
enclose the code below in a function see if it is called
call another function to start the process with a login block in the center   */




?>
<?php function loggedin ($result){
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="script.js?v=1"></script>
        <link rel="stylesheet" type="text/css" href="style.css?v=1">

        <title>
            MovieList
        </title>
        <style>
           
            
        </style>
        
        <script>
       $(document).ready(function(){
           

           
           
            const mov = [];
            var clickcount=0;
            const nxt = document.getElementById('nxt');
            var favcounter=0;
            function sendajax(val)
                {
                    $.ajax({
                            type: "POST",
                            url: "movielist_v2.php", 
                            data: {f : val},
                            success: function (html){
                            console.log("posted form value: "+val);
                        }});
                }
            function initial(){
            
                
            <?php 
            for ($i=0; $i <9 ; $i++) { 
                ?>
                var doc = $("#<?php echo $i+1;?> .text-box");
                console.log(doc);
                $("#<?php echo $i+1;?> .img-box").html("<img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/<?php echo$result[$i]->poster_path?>\"/>");
                $("#<?php echo $i+1;?> .text-box").html("<h3><?php echo$result[$i]->title?></h3><p class=\"date\"><?php echo$result[$i]->release_date?>  <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"o<?php echo $i;?>\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a<?php echo$i;?>\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : <?php echo$result[$i]->popularity?> <br> Original Language : <?php echo $result[$i]->original_language;?> <br> Vote Count: <?php echo $result[$i]->vote_count;?> <br> Average : <?php echo $result[$i]->vote_average;?> </span><span class=\"inneroverview\"> Synopsis <br> <?php echo addslashes($result[$i]->overview);?></span></p> <input type=\"hidden\" id=\"i<?php echo $i;?>\" value=\"<?php echo $result[$i]->id;?>\"/>");
                
                <?php
            }
        
            ?>
            favorites();
            }

           

            initial();
            
            function favorites ()
            {
                $(document).ready(function(){
                 
                var fav = document.querySelectorAll('[id^="icons"]');
                
            
                for (let k = 0; k < 9; k++) {
                    
                    fav[k].addEventListener('click', function favor (){
                        
                        var checker = fav[k].innerHTML;
                        console.log(checker);

                    if (checker=="favorite_border") {
                        sendfav(k, true);
                        favcounter++;
                        console.log(favcounter);
                        fav[k].innerHTML = "favorite";
                    }
                    else
                    {
                        favcounter--;
                        sendfav(k, false);
                        fav[k].innerHTML = "favorite_border";
                    }
    
                    });
                    
                }
            });
        }
            
            nxt.addEventListener('click', function handle(){
                clickcount++;
                if (clickcount==1) {
                    <?php 
                    $counter=1;
                    for ($i=9; $i<18 ; $i++) 
                    { 
                    ?>
                         $("#<?php echo $counter;?> .img-box").html("<img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/<?php echo$result[$i]->poster_path?>\"/>");
                         $("#<?php echo $counter;?> .text-box").html("<h3><?php echo$result[$i]->title?></h3><p class=\"date\"><?php echo$result[$i]->release_date?>   <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"o<?php echo $i;?>\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a<?php echo$i;?>\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : <?php echo$result[$i]->popularity?> <br> Original Language : <?php echo $result[$i]->original_language;?> <br> Vote Count: <?php echo $result[$i]->vote_count;?> <br> Average : <?php echo $result[$i]->vote_average;?> </span><span class=\"inneroverview\"> Synopsis <br> <?php echo addslashes($result[$i]->overview);?></span></p><input type=\"hidden\" id=\"i<?php echo $counter-1;?>\" value=\"<?php echo $result[$i]->id;?>\"/>");
                    <?php 
                $counter++;
                }?>
                   favorites(); 
                }
                else if (clickcount==2) {
                    <?php 
                    $counter=1;
                    for ($i=18; $i<27 ; $i++) 
                    { 
                    ?>
                         $("#<?php echo $counter;?> .img-box").html("<img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/<?php echo$result[$i]->poster_path?>\"/>");
                         $("#<?php echo $counter;?> .text-box").html("<h3><?php echo$result[$i]->title?></h3><p class=\"date\"><?php echo$result[$i]->release_date?>   <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"o<?php echo $i;?>\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a<?php echo$i;?>\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : <?php echo$result[$i]->popularity?> <br> Original Language : <?php echo $result[$i]->original_language;?> <br> Vote Count: <?php echo $result[$i]->vote_count;?> <br> Average : <?php echo $result[$i]->vote_average;?> </span><span class=\"inneroverview\"> Synopsis <br> <?php echo addslashes($result[$i]->overview);?></span></p> <input type=\"hidden\" id=\"i<?php echo $counter-1;?>\" value=\"<?php echo $result[$i]->id;?>\"/>");
                    <?php 
                $counter++;
                
                }?>
                favorites();    
                }
                else if (clickcount==3) {
                    
                    <?php 
                    $counter=1;
                    for ($i=27; $i<36 ; $i++) 
                    { 
                    ?>
                         $("#<?php echo $counter;?> .img-box").html("<img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/<?php echo$result[$i]->poster_path?>\"/>");
                         $("#<?php echo $counter;?> .text-box").html("<h3><?php echo$result[$i]->title?></h3><p class=\"date\"><?php echo$result[$i]->release_date?>   <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"o<?php echo $i;?>\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a<?php echo$i;?>\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : <?php echo$result[$i]->popularity?> <br> Original Language : <?php echo $result[$i]->original_language;?> <br> Vote Count: <?php echo $result[$i]->vote_count;?> <br> Average : <?php echo $result[$i]->vote_average;?> </span><span class=\"inneroverview\"> Synopsis <br> <?php echo addslashes($result[$i]->overview);?></span></p> <input type=\"hidden\" id=\"i<?php echo $counter-1;?>\" value=\"<?php echo $result[$i]->id;?>\"/>");
                    <?php 
                $counter++;
                }?>
                    favorites();
                }
                else if (clickcount==4) {
                    <?php 
                    $counter=1;
                    for ($i=36; $i<45 ; $i++) 
                    { 
                    ?>
                         $("#<?php echo $counter;?> .img-box").html("<img title=\"click for preview\" src=\"http://image.tmdb.org/t/p/w500/<?php echo$result[$i]->poster_path?>\"/>");
                         $("#<?php echo $counter;?> .text-box").html("<h3><?php echo$result[$i]->title?></h3><p class=\"date\"><?php echo$result[$i]->release_date?>   <span class=\"material-icons\" name=\"icons\" id=\"icons\">favorite_border</span></p><p class=\"texts\"><button class=\"ovrview\" id=\"o<?php echo $i;?>\" onclick=\"showsumm(this)\"> Overview </button><button class=\"addin\" id=\"a<?php echo$i;?>\" onclick=\"showinfo(this)\" disabled>Info</button><br> <span class=\"innertext\"> Popularity : <?php echo$result[$i]->popularity?> <br> Original Language : <?php echo $result[$i]->original_language;?> <br> Vote Count: <?php echo $result[$i]->vote_count;?> <br> Average : <?php echo $result[$i]->vote_average;?> </span><span class=\"inneroverview\"> Synopsis <br> <?php echo addslashes($result[$i]->overview);?></span></p> <input type=\"hidden\" id=\"i<?php echo $counter-1;?>\" value=\"<?php echo $result[$i]->id;?>\"/>");
                    <?php 
                $counter++;
                }?>
                  favorites();  
                }
                else if (clickcount==5) 
                {
                    clickcount=0;
                    initial();                   
                }
            });

           
          $(".home").click(function ()
          {
            innertext = "<div class=\"img-wrapper\" id=\"1\"> <div class=\"img-box\"></div><div class=\"text-box\"></div></div> <div class=\"img-wrapper\" id=\"2\"> <div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"3\"><div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"4\"><div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"5\"> <div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"6\"><div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"7\"><div class=\"img-box\"></div><div class=\"text-box\"></div></div> <div class=\"img-wrapper\" id=\"8\"><div class=\"img-box\"></div><div class=\"text-box\"></div></div><div class=\"img-wrapper\" id=\"9\"><div class=\"img-box\"></div> <div class=\"text-box\"></div></div>";
            $(".movie-wrapper").html(innertext);
            initial();

        });
        $('.info').hover(function () 
    {
        console.log("hovering");
       // const todisp=document.querySelector('[class="contactinfo"]');
        //todisp.style.display="auto";
        
        const par = $('.info').parent();
       $('.contactinfo').css({'pointer-events':'auto','opacity':'0.95', 'color':'black', 'border-radius':'8px', 'text-align':'left', 'max-width':'300px', 'z-index':'1'});
        //console.log(par);
            $('.contactinfo').hover(function(){
                $('.contactinfo').css({'pointer-events':'auto','opacity':'0.95', 'color':'black', 'border-radius':'8px', 'text-align':'left', 'max-width':'300px', 'z-index':'1'});
            }, function(){
                $('.contactinfo').css({'opacity':'0','pointer-events':'none'});
            });
    }, function(){
        $('.contactinfo').css({'opacity':'0', 'pointer-events':'none'});
    });
        });

        /*
        function returnhome(savedelemetns)
        {
          
            $(".home").click(function()
            {
                
                $(".movie-wrapper").html(savedelemetns);
                initial();
            });
        }*/

        function showsumm(el)
        {
           console.log(el);
           el.disabled=true;
           const infobtn = el.nextSibling;
           const par = el.parentNode;
           console.log(infobtn);
           infobtn.disabled=false;
           const text = par.querySelector('[class="innertext"]');
           console.log(text);
           text.style.display="none";
           const sumr = text.nextSibling;
           console.log(sumr);
           sumr.style.display="block";
        }
        function showinfo(iel)
        {
            console.log(iel);
            iel.disabled=true;
            const summbtn = iel.previousSibling;
            console.log(summbtn);
            summbtn.disabled=false;
            const paren = iel.parentNode;
            const text = paren.querySelector('[class="inneroverview"]');
            console.log(text);
            text.style.display="none";
            const info = paren.querySelector('[class="innertext"]');
            info.style.display="block";
        }
      
        </script>

    </head>
    <body>
        <div class="main">
            <div class ="header-menu">
            <div>
                    <span class="home">Home</span>
                    <span class="faved">Favorites</span>
                    
                </div>
                <div>
                <span class="info">Contact</span><br><br>
                <div class="contactinfo">
                    <p><ul class="cont">
                        <li><i>Name: </i><strong>Kameer-Yadav Sookoo</strong></li>
                    
                    <li><i class="material-icons">email</i>:<strong>kameer.sookoo@gmail.com</strong></li>
                    <li><i class="material-icons">smartphone</i>: <strong>+27 79 494 5713</strong></li>
                    <li><i class="material-icons">link</i>:<a href="https://github.com/coding-acc">Github</a> </li>
                </ul>
                </p>
                </div>
                </div>
                <div>
                <h1>THE MOVIE THING</h1>
                </div>
                <div class="search-box">
                    <div class="search-bar"><input type="text" id="search" placeholder="search movies" />
                    <div class="sicon"><i class="material-icons">search</i></div>
                    <div class="drop" tabindex="1">
                        <ul>
                       
                       </ul>
                    </div> 
                    

                </div>
                </div>
            </div>
            
            <div class="movie-wrapper">
            
                <div class="img-wrapper" id="1">
                    
                  <div class="img-box"></div>  
                <div class="text-box">
                
                </div>
                </div>
                <div class="img-wrapper" id="2">
                <div class="img-box"></div>
                <div class="text-box">

                </div>
                </div>
                <div class="img-wrapper" id="3">
                <div class="img-box"></div>
                <div class="text-box">

                </div>
                </div>
                <div class="img-wrapper" id="4">
                <div class="img-box"></div>
                <div class="text-box">

                </div>    
                </div>
                <div class="img-wrapper" id="5">
                <div class="img-box"></div>
                <div class="text-box">

                </div>    
                </div>
                <div class="img-wrapper" id="6">
                <div class="img-box"></div>
                <div class="text-box">

                </div>         
                </div>
                <div class="img-wrapper" id="7">
                <div class="img-box"></div>
                <div class="text-box">

                </div>              
                </div>
                <div class="img-wrapper" id="8">
                <div class="img-box"></div>
                <div class="text-box">

                </div>              
                </div>
                <div class="img-wrapper" id="9">
                <div class="img-box"></div>
                <div class="text-box">

                </div> 
                  
                </div>
                
            
            </div>
           
            <div class="btn" name="nxt" id="nxt">
                <i class="material-icons">keyboard_arrow_down</i>
            </div>
            <div class="footer">
            <span id="display"></span>
            </div>
        </div>
    </body>
</html>
<?php }
if ($_SESSION['loggedin']) {
    loggedin($results);
}
else
{
    echo "please log in";
}

if (!empty($_POST['f'])) {
    echo"not empty";
}
if (isset($_POST['search'])) {
    //Search box value assigning to $Name variable.
       $Name = $_POST['search'];
      // echo "sent: {$Name}";
}
if (isset($_POST['movid'])) {
    $movieid = $_POST['movid'];
    //echo "sent : {$movieid}";

    echo "<script> var tester = {$movieid}; console.log(tester);</script>";
}
//loggedin($results);?>