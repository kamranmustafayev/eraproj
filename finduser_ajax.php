<?php
include('inc/sescheck.php');

if(!empty($_POST['finduser']))
{
    $finduser = trim($_POST['finduser']);
    $finduser = strip_tags($finduser);
    $finduser = htmlspecialchars($finduser);
    $finduser = mysqli_real_escape_string($con,$finduser);
}
?>
<body>
    <br><br>
<div class="container">
    <br>
    <div class="text-center">
        <div class="card card-op">
            <div class="card-body text-start">
                <h3 class="card-title text-start">Find</h3>
                <p></p>
                <br>
                    <input type="text" class="form-control" id="finduser" placeholder="Username or ID" value="<?php echo $finduser; ?>"><br>
                    <button class="form-control btn btn-outline-light findbut">Search</button>
                <br>
                <?php
                if(!empty($_POST['finduser']))
                {
                    echo '<ul class="list-group list-group-flush ppl">';
                    $check = mysqli_query($con,"SELECT id,username FROM accounts WHERE (username LIKE '%".$finduser."%' OR id='".$finduser."') AND id!='".$uinfo['id']."'");
                    if(mysqli_num_rows($check) > 0)
                    {
                        while($info = mysqli_fetch_array($check))
                        {
                            echo '
                        <li class="list-group-item clearfix goperson" id="'.$info['id'].'">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Nicaragua.svg/1200px-Flag_of_Nicaragua.svg.png" alt="avatar">
                            <div class="about">
                            <div class="name">'.$info['username'].'</div>
                            </div>
                        </li>';
                        }
                    }
                    else
                    {
                        echo 'Nothing found';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
        <br>
    </div>
</div>
    <nav class="bnav">
    <a href="#" class="bnav_link bnav_link-active profilebut">
        <i class="material-icons bnav_icon">person</i>
        <span class="bnav_text">Profile</span>
    </a>
    <a href="#" class="bnav_link mainbut">
        <i class="material-icons bnav_icon">apps</i>
        <span class="bnav_text">Posts</span>
    </a>
    <a href="#" class="bnav_link chatsbut">
        <i class="material-icons bnav_icon">chat</i>
        <span class="bnav_text">Messages</span>
    </a>
    </nav>
</body>
</html>