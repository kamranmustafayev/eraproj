<?php
include('inc/sescheck.php');

if(empty($_GET['page']))
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
$page = intval($_GET['page']);
$page = (empty($page)) ? 1 : $page;	
$limit = 12;
$start = ($page != 1) ? $page * $limit - $limit : 0;
$check = mysqli_query($con,"SELECT posts.id,accounts.username,accounts.foto,posts.tekst,posts.tarix FROM accounts,friends,posts WHERE (friends.receiverid='".$uinfo['id']."' OR friends.senderid='".$uinfo['id']."') AND accounts.id=posts.senderid GROUP BY posts.id ORDER BY posts.tarix DESC LIMIT ".$start.",".$limit);
while($info=mysqli_fetch_array($check))
{
    $check2 = mysqli_query($con,"SELECT * FROM postlikes WHERE postid='".$info['id']."'");
    $likes = mysqli_num_rows($check2);
    $check3 = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$info['id']."'");
    if(mysqli_num_rows($check3) > 0)
    {
        $likbut = '<button class="btn btn-danger btn-sm fdislikebut" id="'.$info['id'].'">'.$likes.'</button>';
    }
    else
    {
        $likbut = '<button class="btn btn-outline-danger btn-sm flikebut" id="'.$info['id'].'">'.$likes.'</button>';
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