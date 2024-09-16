<?php
include('inc/sescheck.php');

if(empty($_GET['id']))
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
$pid = trim($_GET['id']);
$pid = strip_tags($pid);
$pid = htmlspecialchars($pid);
$pid = mysqli_real_escape_string($con,$pid);
$check = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$pid."'");
if(mysqli_num_rows($check) > 0)
{
  $pinfo = mysqli_fetch_array($check);
}
else
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}


if(isset($_POST['tekst']) && $pid==$uinfo['id'])
{
    $tekst = trim($_POST['tekst']);
    $tekst = strip_tags($tekst);
    $tekst = htmlspecialchars($tekst);
    $tekst = mysqli_real_escape_string($con,$tekst);
    if(!empty($_POST['tekst']))
    {
        $tarix = date('Y-m-d H:i:s');
        $ins = mysqli_query($con,"INSERT INTO posts(senderid,tekst,pageid,tarix) VALUES('".$uinfo['id']."','".$tekst."','".$pid."','".$tarix."')");
        if($ins == false)
        {
            echo 'Ошибка';
        }
    }
}
if(isset($_POST['addfrbut']) && $uinfo['id'] != $pid)
{
  $check = mysqli_query($con,"SELECT * FROM friends WHERE (senderid='".$uinfo['id']."' AND receiverid='".$pid."') OR (receiverid='".$uinfo['id']."' AND senderid='".$pid."')");
  if(mysqli_num_rows($check) == 0)
  {
    $ins = mysqli_query($con,"INSERT INTO friends(senderid,receiverid) VALUES('".$uinfo['id']."','".$pid."')");
  }
  else
  {
    $info = mysqli_fetch_array($check);
    if($info['receiverid'] == $uinfo['id'] && $info['checked'] < 2)
    {
      $upd = mysqli_query($con,"UPDATE friends SET checked='2' WHERE id='".$info['id']."'");
    }
  }
}

if(isset($_POST['delfrbut']) && $uinfo['id'] != $pid)
{
  $check = mysqli_query($con,"SELECT * FROM friends WHERE (senderid='".$uinfo['id']."' AND receiverid='".$pid."') OR (receiverid='".$uinfo['id']."' AND senderid='".$pid."')");
  if(mysqli_num_rows($check) > 0)
  {
    $info = mysqli_fetch_array($check);
    if($info['senderid'] == $uinfo['id'])
    {
      if($info['checked'] < 2)
      {
        $del = mysqli_query($con,"DELETE FROM friends WHERE id='".$info['id']."'");
      }
      else
      {
        $upd = mysqli_query($con,"UPDATE friends SET senderid='".$pid."', receiverid='".$uinfo['id']."', checked='1' WHERE id='".$info['id']."'");
      }
    }
    else if($info['senderid'] == $pid && $info['checked'] == 2)
    {
      $upd = mysqli_query($con,"UPDATE friends SET checked='1' WHERE id='".$info['id']."'");
    }
  }
}
if(!empty($_POST['likbut']))
{
  $postid = trim($_POST['postid']);
  $postid = strip_tags($postid);
  $postid = htmlspecialchars($postid);
  $postid = mysqli_real_escape_string($con,$postid);
  echo $postid.' bau';
  $check = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$postid."'");
  if(mysqli_num_rows($check) == 0)
  {
    $ins = mysqli_query($con,"INSERT INTO postlikes(postid,likerid) VALUES('".$postid."','".$uinfo['id']."')");
  }
}
if(!empty($_POST['disbut']))
{
  $postid = trim($_POST['postid']);
  $postid = strip_tags($postid);
  $postid = htmlspecialchars($postid);
  $postid = mysqli_real_escape_string($con,$postid);
  $check = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$postid."'");
  if(mysqli_num_rows($check) > 0)
  {
    $ins = mysqli_query($con,"DELETE FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$postid."'");
  }
}


if($pid!=$uinfo['id'])
{  
  $check = mysqli_query($con,"SELECT * FROM friends WHERE (senderid='".$uinfo['id']."' AND receiverid='".$pid."') OR (receiverid='".$uinfo['id']."' AND senderid='".$pid."')");
  if(mysqli_num_rows($check) > 0)
  {
    $info = mysqli_fetch_array($check);
    if($info['checked'] <= 1)
    {
      if($info['senderid'] == $uinfo['id'])
      {$button1 = '<button class="btn btn-outline-secondary delfr" id="frbut" uid="'.$pid.'">Subscribed</button>';}
      if($info['senderid'] == $pid)
      {$button1 = '<button class="btn btn-outline-secondary addfr" id="frbut" uid="'.$pid.'">Friend request</button>';}
    }
    if($info['checked'] == 2)
    {
      $button1 = '<button class="btn btn-outline-light delfr" id="frbut" uid="'.$pid.'">Your friend</button>';
    }
  }
  else
  {
    $button1 = '<button class="btn btn-outline-primary addfr" id="frbut" uid="'.$pid.'">To friends</button> ';
  }
  $button1 = $button1.'&nbsp<button class="btn btn-primary gochat id="chatid" data-chatid="'.$pid.'">Message</button>';
}
else
{
  $button1 = '<button class="btn btn-outline-secondary goedit">Edit profile</button>';
}
    
?>
<body>
  <div class="container py-5">
        <div class="card card-dop mb-4">
          <div class="card-body text-center">
            <img class="prof" src="<?php echo $pinfo['foto']; ?>" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php echo $pinfo['username']; ?></h5>
            <h6 class="text-muted mb-4">skoro</h6>
            <div class="d-flex justify-content-center mb-2">
              <?php
              echo $button1;
              ?>
            </div>
          </div>
        </div>
        <div class="card card-dop mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col">
                <p class="text-muted text-end mb-0"><?php echo $pinfo['realname'].' '.$pinfo['realsurname']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <p class="mb-0">Birth Date</p>
              </div>
              <div class="col">
                <p class="text-muted text-end mb-0"><?php echo $pinfo['realdr']; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <p class="mb-0">Gender</p>
              </div>
              <div class="col">
                <?php
                if($pinfo['realpol'] == 1)
                {
                  $pol = 'Male';
                }
                else if($pinfo['realpol'] == 2)
                {
                  $pol = 'Female';
                }
                else
                {
                  $pol = 'Unknown';
                }
                ?>
                <p class="text-muted text-end mb-0"><?php echo $pol; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <p class="mb-0">ID:</p>
              </div>
              <div class="col">
                <p class="text-muted text-end mb-0"><?php echo $pid; ?></p>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" id="userid" value="<?php echo $pid; ?>">

        <?php
        if($pid == $uinfo['id'])
        {
          echo '<div class="card card-dop mb-4 mb-md-0">
            <div class="card-body">
                <form method="post">
                    <textarea class="form-control areadark" id="tekst" placeholder="Write smth..." data-uid="'.$pid.'"></textarea><br>
                    <button class="btn btn-outline-primary newpost">Send</button>
                </form>
            </div>
          </div>';
        }
        ?>
        <div class="card card-dop mb-4 mb-md-0">
            <div class="card-body">
                <h5>Posts</h5>
                <div id="psts" class="pst">
                  <?php
                  $check = mysqli_query($con,"SELECT posts.id,posts.senderid, accounts.foto, accounts.username, posts.tarix, posts.tekst FROM posts,accounts WHERE posts.pageid='".$pid."' AND posts.senderid=accounts.id ORDER BY id DESC LIMIT 12");
                  $check2 = mysqli_query($con,"SELECT posts.id,posts.senderid, accounts.username, posts.tarix, posts.tekst FROM posts,accounts WHERE posts.pageid='".$pid."' AND posts.senderid=accounts.id");
                  $amt = mysqli_num_rows($check2);
                  $amt = ceil($amt/12);
                  while($postinfo=mysqli_fetch_array($check))
                  {
                    $check2 = mysqli_query($con,"SELECT * FROM postlikes WHERE postid='".$postinfo['id']."'");
                    $likes = mysqli_num_rows($check2);
                    $check3 = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$postinfo['id']."'");
                    if(mysqli_num_rows($check3) > 0)
                    {
                      $likbut = '<button class="btn btn-danger btn-sm pdislikebut" id="'.$postinfo['id'].'">'.$likes.'</button>';
                    }
                    else
                    {
                      $likbut = '<button class="btn btn-outline-danger btn-sm plikebut" id="'.$postinfo['id'].'">'.$likes.'</button>';
                    }
                    echo '
                    <div class="card card-op mb-4 mb-md-0">
                      <div class="card-body">
                        <div class="clearfix">
                          <img src="'.$postinfo['foto'].'" alt="avatar">
                          <div class="about">
                          <div class="name">'.$postinfo['username'].'</div>
                          <div class="status">
                            <i class="fa fa-circle online"></i> '.$postinfo['tarix'].'
                          </div>
                          </div>
                        </div>
                        <div class="postinfo">'.$postinfo['tekst'].'</div><br>
                        <div>'.$likbut.'</div>
                      </div>
                    </div>';
                  }
                  ?>
                </div>
                <div id="showmore-triger" data-page="1" data-max="<?php echo $amt; ?>">
            </div>
        </div>
    </div>
  </div>
    <nav class="bnav">
    <a href="#" class="bnav_link bnav_link-active profilebut">
        <i class="material-icons bnav_icon">person</i>
        <span class="bnav_text">Profile</span>
    </a>
    <a href="#" class="bnav_link mainbut">
        <i class="material-icons bnav_icon">apps</i>
        <span class="bnav_text">Feed</span>
    </a>
    <a href="#" class="bnav_link chatsbut">
        <i class="material-icons bnav_icon">chat</i>
        <span class="bnav_text">Chats</span>
    </a>
    </nav>
</body>
</html>
<script>
  block_show = false;
  function scrollMore()
  {
    let $target = $('#showmore-triger')
    if (block_show) {
      return false;
    }	
    if ($target.attr('data-page') < $target.attr('data-max'))
    {
      let wt = $(window).scrollTop();
      let wh = $(window).height();
      let et = $target.offset().top;
      let eh = $target.outerHeight();
      let dh = $(document).height();   
    
      if (wt + wh >= et || wh + wt == dh || eh + et < wh)
      {
        uid = document.getElementById('userid').value
        let page = $target.attr('data-page');
        page++;
        block_show = true;

        $.ajax({ 
        type:'post',
        url: 'psts_ajax.php?page=' + page,  
        data: {personid:uid},
        success: function(data){
          $('#psts').append(data);
          block_show = false;
        }
        });
        $target.attr('data-page', page);
      }
    }
  }
  $(window).scroll(function(){
	scrollMore();
  });

</script>