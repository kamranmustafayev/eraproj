<?php
session_start();
$con = mysqli_connect('localhost','root','','era');
if(isset($_SESSION['era_uid']))
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
$tarix = date('Y-m-d');
$msg = "";
if(isset($_POST['username']))
{
    $username = trim($_POST['username']);
    $username = strip_tags($username);
    $username = htmlspecialchars($username);
    $username = mysqli_real_escape_string($con,$username);
    $username = strtolower($username);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    $email = mysqli_real_escape_string($con,$email);
    $email = strtolower($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    $pass = mysqli_real_escape_string($con,$pass);

    $repass = trim($_POST['repassword']);
    $repass = strip_tags($repass);
    $repass = htmlspecialchars($repass);
    $repass = mysqli_real_escape_string($con,$repass);

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

    $regtime = date('Y-m-d H:i:s');
    $regcheck = strtotime($tarix);
    $drcheck = strtotime($realdr);
    $obcheck = $regcheck - $drcheck;
    if(!empty($realname) && !empty($realsurname) && !empty($realdr) && !empty($realpol) && !empty($username) && !empty($email) && !empty($pass) && !empty($repass) && $realpol > 0 && $realpol < 3)
    {
        if(!preg_match('/[^A-Za-z0-9]/', $username) && strpos($username, ' ') == false)
        {
            if(!preg_match('/[^A-Za-z]/', $realname) && !preg_match('/[^A-Za-z]/', $realsurname) && strpos($realname, ' ') == false && strpos($realsurname, ' ') == false)
            {
                if($obcheck > 410227200 & $obcheck < 3155756400 && $drcheck > 0)
                {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        if(!preg_match('/\p{Cyrillic}/u', $username) && !preg_match('/\p{Cyrillic}/u', $email) && !preg_match('/\p{Cyrillic}/u', $pass) && !preg_match('/\p{Cyrillic}/u', $repass))
                        {
                            if($realpol > 0 && $realpol < 3)
                            {
                                $check = mysqli_query($con,"SELECT * FROM accounts WHERE email='".$email."'");
                                $check2 = mysqli_query($con,"SELECT * FROM accounts WHERE username='".$username."'");
                                if(mysqli_num_rows($check)==0 && mysqli_num_rows($check2)==0)
                                {
                                    if(strlen($realname) < 30 && strlen($realsurname) > 2 && strlen($realsurname) < 30 && strlen($realsurname) > 2 && strlen($username) < 22 && strlen($username) > 2 && strlen($email) < 50 && strlen($email) > 4 && strlen($pass) < 25 && strlen($pass) > 5)
                                    {
                                        if($pass == $repass && strpos($pass, ' ') == false)
                                        {
                                            $checked = 0;
                                            while($checked == 0)
                                            {
                                                $newid = mt_rand(1000000,89999999);
                                                $check = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$newid."'");
                                                if(mysqli_num_rows($check)==0)
                                                {
                                                    $checked = 1;
                                                }
                                            }
                                            $pass = sha1($pass);
                                            $ins = mysqli_query($con,"INSERT INTO accounts(id,username,email,pass,regtime,lasttime,regip,realname,realsurname,realdr,realpol) VALUES('".$newid."','".$username."','".$email."','".$pass."','".$regtime."','".$regtime."','".$_SERVER['REMOTE_ADDR']."','".$realname."','".$realsurname."','".$realdr."','".$realpol."')");
                                            if($ins==true)
                                            {
                                                $_SESSION['era_uid'] = $newid;
                                                echo'<meta http-equiv="refresh" content="0;url=verify.php" />'; exit;
                                            }
                                            else
                                            {
                                                $msg = 'Error.';
                                            }
                                        }
                                        else
                                        {
                                            $msg = 'Passwords do not match.';
                                        }
                                    }
                                    else
                                    {
                                        $msg = 'Number of characters more/less than required.';
                                    }
                                }
                                else
                                {
                                    $msg = 'Account with this email or nickname has already been registered.';
                                }
                            }
                            else
                            {
                                $msg = 'Wrong gender.';
                            }
                        }
                        else
                        {
                            $msg = 'Data must not contain Cyrillic.';
                        }
                    }
                    else
                    {
                        $msg = 'Email is incorrect.';
                    }
                }
                else
                {
                    $msg = 'Birth date is incorrect.';
                }   
            }
            else
            {
                $msg = 'First Name, Last Name must contain only latin letters.';
            }
        }
        else
        {
            $msg = 'Username must contain latin letters and digits.';
        }
    }
    else
    {
        $msg = 'Fill in all the fields.';
    }
}
?>
<body>
    <div class="container">
    <br>
        <br>
        <h2 class="d-flex justify-content-center">EXPEON</h2>
        <p class="d-flex justify-content-center">Fill in the fields to sign up.</p>
        <br><br>
        <div class="window row d-flex justify-content-center">
            <?php
            echo $msg;
            ?>
            <div>
            <form method="post">
                First Name:<br>
                <input type="text" required class="form-control" id="realname" placeholder="Elon"><br>
                Last Name:<br>
                <input type="text" required class="form-control" id="realsurname" placeholder="Musk"><br>
                Choose gender:<br>
                <select class="form-control sel-dop" id="realpol">
                    <option selected disabled value="0">Select</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select><br>
                Birth Date:<br>
                <input type="date" required class="form-control" id="realdr" value="<?php echo $tarix; ?>"><br>
                Username:<br>
                <input type="text" required class="form-control" id="username" placeholder="elonmusk"><br>
                Email:<br>
                <input type="email" required class="form-control" id="email" placeholder="elon@example.com"><br>
                Password:<br>
                <input type="password" required class="form-control" id="password" placeholder="······"><br>
                Confirm password:<br>
                <input type="password" required class="form-control" id="repassword" placeholder="······"><br>
                <button class="btn btn-outline-primary reqbut">Complete registration</button><br>
            </form>
            <p style="margin: 5px;">Already have an account? <a class="logbut" style="color: #eeeeee;" href="">Sign in</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>