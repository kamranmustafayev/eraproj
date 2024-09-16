<?php
include('inc/sescheck.php');

if(empty($_POST['personid']) && empty($_GET['page']))
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
$personid = intval($_POST['personid']);
$personid = trim($personid);
$personid = strip_tags($personid);
$personid = htmlspecialchars($personid);
$personid = mysqli_real_escape_string($con,$personid);

$page = intval($_GET['page']);
$page = (empty($page)) ? 1 : $page;	
$limit = 12;
$start = ($page != 1) ? $page * $limit - $limit : 0;
$check = mysqli_query($con,"SELECT posts.id,posts.senderid, accounts.username, accounts.foto, posts.tarix, posts.tekst FROM posts,accounts WHERE posts.pageid='".$personid."' AND posts.senderid=accounts.id ORDER BY posts.id DESC LIMIT ".$start.",".$limit);
while($info=mysqli_fetch_array($check))
{
    $check2 = mysqli_query($con,"SELECT * FROM postlikes WHERE postid='".$info['id']."'");
    $likes = mysqli_num_rows($check2);
    $check3 = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$info['id']."'");
    if(mysqli_num_rows($check3) > 0)
    {
        $likbut = '<button class="btn btn-danger btn-sm pdislikebut" id="'.$info['id'].'">'.$likes.'</button>';
    }
    else
    {
        $likbut = '<button class="btn btn-outline-danger btn-sm plikebut" id="'.$info['id'].'">'.$likes.'</button>';
    }
    echo '
    <div class="card card-op mb-4 mb-md-0">
        <div class="card-body">
        <div class="clearfix">
            <img src="'.$info['foto'].'" alt="avatar">
            <div class="about">
            <div class="name">'.$info['username'].'</div>
            <div class="status">
            <i class="fa fa-circle online"></i> '.$info['tarix'].'
            </div>
            </div>
        </div>
        <div class="postinfo">'.$info['tekst'].'</div><br>
        <div class="likebut">'.$likbut.'</div>
        </div>
    </div>';
}
?>