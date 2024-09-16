<?php
include('inc/sescheck.php');

?>
<body>
  <div class="container py-5">
        <div class="card card-dop mb-4">
          <div class="card-body text-center">
            <img class="prof" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Nicaragua.svg/1200px-Flag_of_Nicaragua.svg.png" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php echo $uinfo['username']; ?></h5>
            <h6 class="text-muted mb-4">soon..</h6>
            <div class="d-flex justify-content-center mb-2">
              <button type="button" class="btn btn-primary">chto-to</button>
              <button type="button" class="btn btn-outline-primary ms-1">ewe chto-to</button>
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
                <p class="text-muted text-end mb-0">...</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <p class="mb-0">Date of birth</p>
              </div>
              <div class="col">
                <p class="text-muted text-end mb-0">...</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <p class="mb-0">Gender</p>
              </div>
              <div class="col">
                <p class="text-muted text-end mb-0">...</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card card-dop mb-4 mb-md-0">
            <div class="card-body">
                <form method="post">
                    <textarea class="form-control areadark" id="tekst" placeholder="Write smth..."></textarea><br>
                    <button class="btn btn-outline-primary newpost">Send</button>
                </form>
            </div>
        </div>
        <div class="card card-dop mb-4 mb-md-0">
            <div class="card-body">
                <h5>Посты</h6>
                <div id="psts" class="pst">
                <?php
                $check = mysqli_query($con,"SELECT posts.id,posts.senderid, accounts.username, posts.tarix, posts.tekst FROM posts,accounts WHERE posts.pageid='".$uinfo['id']."' AND posts.senderid=accounts.id ORDER BY id DESC LIMIT 12");
                $check2 = mysqli_query($con,"SELECT posts.id,posts.senderid, accounts.username, posts.tarix, posts.tekst FROM posts,accounts WHERE posts.pageid='".$uinfo['id']."' AND posts.senderid=accounts.id");
                $amt = mysqli_num_rows($check2);
                $amt = ceil($amt/12);
                while($info=mysqli_fetch_array($check))
                {
                $check2 = mysqli_query($con,"SELECT * FROM postlikes WHERE postid='".$info['id']."'");
                $likes = mysqli_num_rows($check2);
                $check3 = mysqli_query($con,"SELECT * FROM postlikes WHERE likerid='".$uinfo['id']."'");
                if(mysqli_num_rows($check3) > 0)
                {
                    $likbut = '<button class="btn btn-danger btn-sm dislikebut" id="likbut" pid="'.$postinfo['id'].'">'.$likes.'</button>';
                }
                else
                {
                    $likbut = '<button class="btn btn-outline-danger btn-sm likebut" id="likbut" pid="'.$postinfo['id'].'">'.$likes.'</button>';
                }
                echo '
                <div class="card card-op mb-4 mb-md-0">
                    <div class="card-body">
                    <div class="clearfix">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Nicaragua.svg/1200px-Flag_of_Nicaragua.svg.png" alt="avatar">
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
                </div>
                <div id="showmore-triger" data-page="1" data-max="<?php echo $amt; ?>">
            </div>
        </div>
    </div>
  </div>
    <nav class="bnav">
    <a href="#" class="bnav_link bnav_link-active profilebut">
        <i class="material-icons bnav_icon">person</i>
        <span class="bnav_text">Профиль</span>
    </a>
    <a href="#" class="bnav_link mainbut">
        <i class="material-icons bnav_icon">apps</i>
        <span class="bnav_text">Посты</span>
    </a>
    <a href="#" class="bnav_link chatsbut">
        <i class="material-icons bnav_icon">chat</i>
        <span class="bnav_text">Сообщения</span>
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
        url: 'psts_ajax.php?page=' + page,  
        dataType: 'html',
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