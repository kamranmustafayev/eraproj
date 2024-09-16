<?php
session_start();
$con = mysqli_connect('localhost','root','','era');
$msg = '<br>';
if(isset($_SESSION['era_uid']))
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
if(isset($_POST['username']))
{
    $username = trim($_POST['username']);
    $username = strip_tags($username);
    $username = htmlspecialchars($username);
    $username = mysqli_real_escape_string($con,$username);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    $pass = mysqli_real_escape_string($con,$pass);

    if(!empty($username) && !empty($pass))
    {
        $pass = sha1($pass);
        $check = mysqli_query($con,"SELECT * FROM accounts WHERE username='".$username."' AND pass='".$pass."'");
        if(mysqli_num_rows($check)>0)
        {
            $info = mysqli_fetch_array($check);
            $_SESSION['era_uid'] = $info['id'];
            echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;
        }
        else
        {
            $msg = '<div class="alert alert-danger">Wrong username or password.</div>';
        }    
    }
    else
    {
        $msg = '<div class="alert alert-danger">Fill in all the fields.</div>';
    }
    
}
?>
<body>
    <div class="container">
        <br>
        <br>
        <h2 class="d-flex justify-content-center">EXPEON</h2>
        <p class="d-flex justify-content-center">Log in to continue</p>
        <br><br>
        <?php
        echo $msg;
        ?>
        <div class="window row d-flex justify-content-center">
            <div>
            <form method="post">
                Username:<br>
                <input type="text" class="form-control" id="username" placeholder="username"><br>
                Password:<br>
                <input type="password" class="form-control" id="password" placeholder="······"><br>
                <button class="btn btn-outline-primary logfuncbut">Log in</button><br>
            </form>
            <p style="margin: 5px;">Don't have an account? <a class="regbut" style="color: #eeeeee;" href="">Create new</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>