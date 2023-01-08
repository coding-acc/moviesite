<?php
require_once 'connection.php';
session_start();
$fail="";

try
{
	$pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e)
{
	throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    if (empty($_POST['usrname']) || empty($_POST['pword'])) {
        $fail = "Please complete all fields";
    }
    else 
    {
        $password = $_POST['pword'];
        
        $username = $_POST['usrname'];
        
        $sql = "SELECT id, username, pass FROM usertbl WHERE username ='{$username}'";
        $result = $pdo->query($sql);
        if($result->rowCount())
        {
            while($row = $result->fetch())
            {
                $usr = $row['username'];
                $pass = $row['pass'];

                if ($pass!= $password) 
                {
                    $fail = "Incorrect password";
                }
                else {
                    $_SESSION['user']=$usr;
                    $_SESSION['id']=$row['id'];
                    $_SESSION['loggedin']=true;
                    header("Location: http://localhost/movieViewer/movielist_v2.php");
                    
                }
            }
        }
        else
        {
            $fail="incorrect username";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <title>
            MovieList Login
        </title>
        <style>
            body
            {
                background-color: whitesmoke;

            }
            input 
            {
                border: 1px solid black;
            }
            .l-form
            {
                background-color: whitesmoke;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 15px;
                border-radius: 8px;
                border: 1px solid lightskyblue;
                box-shadow: 2px 2px 2px 2px rgba(111, 112, 111, 0.2), 2px 2px 2px 2px rgba(100, 111, 111, 0.22);

            }
            #pword
            {
                border-radius: 8px;
                font: 1.4rem molot;
                font-size: 12px;


            }
            #usrname
            {
                border-radius: 8px;
                font: 1.4rem molot;
                font-size: 12px;


            }
            span
            {
                color: red;
                font-size: 8px;
            }
            h1
            {
                text-align: center;
                font: 1.4rem molot;
                text-shadow: 1px 1px 1px #fff, 2px 2px 1px #000;
                font-size: 22px;
            }
            #log
            {
                position: relative;
                top: 50%;
                left: 40%;
                
                border-radius: 8px;
                font: 1.4rem molot;
                font-size: 15px;
                
                
            }
            input:hover
            {
                cursor: pointer;
                border: 1px solid lightskyblue;
                box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.22);
            }
            
        </style>
    </head>
    <body>
    <div class="l-form">
    <h1>Movielist Login</h1>
    <form id="login" action="log_page.php" method="post" onsubmit=" return validate(this)">
        <label for="usrname">Username: </label>
        
        <input type="text" id="usrname" name="usrname"></input>
        <br><br>
        <label for="pword">Password: </label>
        <input type="text" id="pword" name="pword"></input>
        <br>
        <span class="fail"><?php echo $fail;?></span>
       <br>
       <input type="submit" id="log" name="log"></input>
       
    </form>
</div>
    </body>
</html>