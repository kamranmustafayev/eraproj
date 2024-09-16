<?php
include('inc/sescheck.php');

if(isset($_POST['savebut']))
{
    $username = trim($_POST['username']);
    $username = strip_tags($username);
    $username = htmlspecialchars($username);
    $username = mysqli_real_escape_string($con,$username);
    $username = strtolower($username);

    $realname = trim($_POST['realname']);
    $realname = strip_tags($realname);
    $realname = htmlspecialchars($realname);
    $realname = mysqli_real_escape_string($con,$realname);
    $realname = ucfirst(strtolower($realname));

    $realsurname = trim($_POST['realsurname']);
    $realsurname = strip_tags($realsurname);
    $realsurname = htmlspecialchars($realsurname);
    $realsurname = mysqli_real_escape_string($con,$realsurname);
    $realsurname = ucfirst(strtolower($realsurname));

    $realdr = trim($_POST['realdr']);
    $realdr = strip_tags($realdr);
    $realdr = htmlspecialchars($realdr);
    $realdr = mysqli_real_escape_string($con,$realdr);

    $realpol = trim($_POST['realpol']);
    $realpol = strip_tags($realpol);
    $realpol = htmlspecialchars($realpol);
    $realpol = mysqli_real_escape_string($con,$realpol);
    $realpol = intval($realpol);
    if(!empty($realname) && !empty($realsurname) && !empty($realdr) && !empty($realpol) && !empty($username) && $realpol > 0 && $realpol < 3)
    {
        if(!preg_match('/[^A-Za-z0-9]/', $username) && strpos($username, ' ') == false)
        {
            if(!preg_match('/[^A-Za-z]/', $realname) && !preg_match('/[^A-Za-z]/', $realsurname) && strpos($realname, ' ') == false && strpos($realsurname, ' ') == false)
            {
                if($obcheck > 410227200 & $obcheck < 3155756400 && $drcheck > 0)
                {
                    if(!preg_match('/\p{Cyrillic}/u', $username))
                    {
                        if($realpol > 0 && $realpol < 3)
                        {
                            $check = mysqli_query($con,"SELECT * FROM accounts WHERE username='".$username."'");
                            if(mysqli_num_rows($check)==0)
                            {
                                if(strlen($realname) < 30 && strlen($realsurname) > 2 && strlen($realsurname) < 30 && strlen($realsurname) > 2 && strlen($username) < 22 && strlen($username) > 2 && strlen($email) < 50 && strlen($email) > 4 && strlen($pass) < 25 && strlen($pass) > 5)
                                {
                                    $upd = mysqli_query($con,"UPDATE accounts SET username='".$username."',realname='".$realname."',realsurname='".$realsurname."',realdr='".$realdr."',realpol='".$realpol."' WHERE id='".$uinfo['id']."'");
                                    if($upd==true)
                                    {
                                        $msg= '<div class="alert alert-success">Updated</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="alert alert-danger">Error</div>';
                                    }
                                }
                                else
                                {
                                    $msg = '<div class="alert alert-danger"></div>';
                                }
                            }
                            else
                            {
                                $msg = '<div class="alert alert-danger">Username is taken.</div>';
                            }
                        }
                        else
                        {
                            $msg = '<div class="alert alert-danger">Incorrect gender.</div>';
                        }
                    }
                    else
                    {
                        $msg = '<div class="alert alert-danger">Username should be in latin letters.</div>';
                    }
                }
                else
                {
                    $msg = '<div class="alert alert-danger">Incorrect birth date.</div>';
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger">First Name, Last Name should contain latin letters.</div>';
            }
        }
        else
        {
            $msg = '<div class="alert alert-danger">Username should contain latin letters and digits.</div>';
        }
    }
    else
    {
        $msg = '<div class="alert alert-danger">Fill in all the fields.</div>';
    }
}
if($_FILES['profav']['size'] > 1024)
    {
        if($uinfo['foto'] != 'assets/img/nophoto.png')
        {
            unlink($uinfo['foto']);
        }
        $unvan = 'assets/img/pav/'.basename($_FILES['profav']['name']);

        //JPG Jpg jpg
        $tip = strtolower(pathinfo($unvan,PATHINFO_EXTENSION));

        if($tip!='jpg' && $tip!='jpeg' && $tip!='png' && $tip!='gif' && $tip!='jfif')
        {$error = 1; $msg = '<div class="alert alert-warning" role="alert">Image should have only this types: <b>JPG JPEG PNG GIF</b>.</div>';}

        if($_FILES['profav']['size']>10485760)
        {$error = 1; $msg = '<div class="alert alert-warning" role="alert">Size of image should be less than <b>10 MB</b>.</div>';}


        if(!isset($error))
        {
            $unvan = 'assets/img/pav/'.time().'.'.$tip;
            $upd = mysqli_query($con,"UPDATE accounts SET foto='".$unvan."' WHERE id='".$uinfo['id']."'");
            if($upd==true)
            {
                $msg = 'Myau';
                move_uploaded_file($_FILES['profav']['tmp_name'], $unvan);
            }
            else
            {
                $msg = 'ne myau';
            }
        }
    }

?>
<body>
    <br><br>
<div class="container">
    <br>
    <div class="text-center">
        <div class="card card-op">
            <div class="card-body text-start">
                <h3 class="card-title text-center">Edit Profile</h3>
                <p></p>
                <?php echo $msg; ?>
                <ul class="list-group list-group-flush">
                    <form method="post" name="editform" id="editform" enctype="multipart/form-data">
                    <li class="list-group-item">Change Photo:<br><input type="file" class="form-control" name="profav"></li>
                    <li class="list-group-item">Username:<br><input type="text" class="form-control" name="username" value="<?php echo $uinfo['username']; ?>"></li>
                    <li class="list-group-item">First Name:<br><input type="text" class="form-control" name="realname" value="<?php echo $uinfo['realname']; ?>"></li>
                    <li class="list-group-item">Last Name:<br><input type="text" class="form-control" name="realsurname" value="<?php echo $uinfo['realsurname']; ?>"></li>
                    <li class="list-group-item">Birth date:<br><input type="text" class="form-control" name="realdr" value="<?php echo $uinfo['realdr']; ?>"></li>
                    <li class="list-group-item">Choose gender:<br>
                    <select class="form-control sel-dop" name="realpol">
                        <?php
                        if($uinfo['realpol'] == 1)
                        {
                            $x = 'selected';
                        }
                        else
                        {
                            $y = 'selected';
                        }
                        ?>
                        <option <?php echo $x; ?> value="1">Male</option>
                        <option <?php echo $y; ?> value="2">Female</option>
                    </select><br>
                    </li>
                    <button class="btn btn-outline-primary editbut" name="savebut">Save changes</button>
                    </form>
                </ul>
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