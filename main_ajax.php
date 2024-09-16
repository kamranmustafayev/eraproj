<?php
include('inc/sescheck.php');

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
?>
<body>
    <br><br>
<div class="container">
    <br>
    <div class="card card-dop mb-4 mb-md-0">
        <div class="card-body">
            <h2 class="d-flex justify-content-center">Feed</h2>
            <div id="lenta" class="pst">
            <?php
                $check = mysqli_query($con,"SELECT posts.id,accounts.username,accounts.foto,posts.tekst,posts.tarix FROM accounts,friends,posts WHERE (friends.receiverid='".$uinfo['id']."' OR friends.senderid='".$uinfo['id']."') AND accounts.id=posts.senderid GROUP BY posts.id ORDER BY posts.tarix DESC LIMIT 12");
                $check2 = mysqli_query($con,"SELECT posts.id,accounts.username,posts.tarix FROM accounts,friends,posts WHERE (friends.receiverid='".$uinfo['id']."' OR friends.senderid='".$uinfo['id']."') AND accounts.id=posts.senderid GROUP BY posts.id");
                $amt = mysqli_num_rows($check2);
                $amt = ceil($amt/12);
                while($postinfo=mysqli_fetch_array($check))
                {
                $check2 = mysqli_query($con,"SELECT * FROM postlikes WHERE postid='".$postinfo['id']."'");
                $likes = mysqli_num_rows($check2);
                $check3 = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."' AND postid='".$postinfo['id']."'");
                if(mysqli_num_rows($check3) > 0)
                {
                    $likbut = '<button class="btn btn-danger btn-sm fdislikebut" id="'.$postinfo['id'].'">'.$likes.'</button>';
                }
                else
                {
                    $likbut = '<button class="btn btn-outline-danger btn-sm flikebut" id="'.$postinfo['id'].'">'.$likes.'</button>';
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
            <div id="showmore-triger" data-page="1" data-max="<?php echo $amt; ?>"></div>
        </div>
    </div>
</div>
<nav class="bnav">
    <a href="#" class="bnav_link profilebut">
        <i class="material-icons bnav_icon">person</i>
        <span class="bnav_text">Profile</span>
    </a>
    <a href="#" class="bnav_link bnav_link-active mainbut">
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
        let page = $target.attr('data-page');
        page++;
        block_show = true;

        $.ajax({ 
        type:'get',
        url: 'feed_ajax.php?page=' + page,
        dataType:'html',
        success: function(response){
          $('#lenta').append(response);
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