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

if (isset($_POST['movid'])) {
    //echo"<p> Faved movie is: {$_POST['movid']}";
    $del = false;
    $usid = 1; // set from log in
   $sql = "SELECT favids FROM usertbl WHERE id='{$usid}'";
   $result=$pdo->query($sql);

   if ($result->rowCount()) 
   {
    while ($row = $result->fetch())
    {
        $current = $row['favids'];
        //echo "Current favs are: <br> {$row['favids']} <br>";
        if ($row['favids']=="")
        {
            $updatesql = "UPDATE usertbl SET favids='{$_POST['movid']}' WHERE id='{$usid}'";
            $res=$pdo->query($updatesql); 
        }
        else{
            $favlist = explode(",",$current);
            for($i=0; $i<count($favlist); $i++)
            {
                if ($favlist[$i]==$_POST['movid']) 
                {
                    unset($favlist[$i]);
                    $del=true;
                }
                
            }
            if ($del) {
                $current=implode(",", $favlist);
                $updatesql = "UPDATE usertbl SET favids='{$current}' WHERE id='{$usid}'";
                $res=$pdo->query($updatesql);
            }   
            else
                {
                $newlist =$current.",".$_POST['movid'];
                $updatesql = "UPDATE usertbl SET favids='{$newlist}' WHERE id='{$usid}'";
                $res=$pdo->query($updatesql);
            }
        } 
    } 
   }

}

?>
