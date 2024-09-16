<?php
session_start();
$con = mysqli_connect('localhost','root','','era');
if(!isset($_SESSION['era_uid']))
{echo'<meta http-equiv="refresh" content="0;url=index.php" />'; exit;}
$user = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$_SESSION['era_uid']."'");
$uinfo = mysqli_fetch_array($user);
if($uinfo['userchecked']==0)
{echo'<meta http-equiv="refresh" content="0;url=verify.php" />'; exit;}
if($uinfo['darktheme'] == 0)
{
    echo'<link rel="stylesheet" href="./assets/css/light.css">';
}
else
{
    echo'<link rel="stylesheet" href="./assets/css/dark.css">';
}
$tarix = date('Y-m-d H:i:s');
$tarix2 = strtotime($tarix);
$useronline = strtotime($uinfo['useronline']);
$useronline = $tarix2 - $useronline;
if($useronline > 120)
{
    $upd = mysqli_query($con,"UPDATE accounts SET useronline='".$tarix."' WHERE id='".$uinfo['id']."'");
}
?>