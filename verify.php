<?php
session_start();
$con = mysqli_connect('localhost','root','','era');
if(!isset($_SESSION['era_uid']))
{echo'<meta http-equiv="refresh" content="0;url=index.php" />'; exit;}
$check = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$_SESSION['era_uid']."'");
$uinfo = mysqli_fetch_array($check);
if($uinfo['userchecked'] == 1)
{echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
if(isset($_POST['confirmbut']))
{
    if($_POST['emailcode'] == $uinfo['emailcode'])
    {
        $upd = mysqli_query($con,"UPDATE accounts SET userchecked=1 WHERE id='".$uinfo['id']."'");
        if($upd==true)
        {echo'<meta http-equiv="refresh" content="0;url=main.php" />'; exit;}
        else
        {
            $msg = 'Произошла ошибка';
        }
    }
    else
    {
        $msg = 'Неверный код подтверждения';
    }
}
$current = strtotime(date('Y-m-d H:i:s'));
$nextemail = strtotime($uinfo['nextemail']);
$prov = $current - $nextemail;
if($prov>119)
{
    $nextemail = $current;
    $nextemail = date('Y-m-d H:i:s', $nextemail);
    $emailcode = mt_rand(100000,999999);
    $upd = mysqli_query($con,"UPDATE accounts SET emailcode='".$emailcode."',nextemail='".$nextemail."' WHERE id='".$uinfo['id']."'");
    $to = $uinfo['email'];
    $subject = "Регистрация на сайте";
    $txt = "Hello world!";
    $headers = "From: ERA <registration@expeon.ru>" . "\r\n";
    $msg = "<html>Ваш код для подтверждения регистрации на сайте: \n<center><b>$emailcode</b></center><br>Если вы не знаете что это, 
    то проигнорируйте данное письмо.</html>";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // send email
    $stalin = mail($to,$subject,$msg,$headers);
    $but = '(Письмо отправлено только что)';
}
else
{
    $but = 'Если вам не пришло письмо, перезагрузите страницу через '.$prov.' секунд.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expeon Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/dark.css">
</head>
<?php
$msg = 'На ваш e-mail отправлено письмо с кодом подтверждения регистрации.';
?>
<body>
    <div class="container">
        <br>
        <h2 class="d-flex justify-content-center">Подтверждение</h2>
        <br><br><br><br><br><br>
        <div class="window row d-flex justify-content-center">
            <?php
            echo '<input type="hidden" id="prov" value="'.$prov.'">';
            echo $msg;
            ?>
            <div id="schet"><?php echo $but; ?></div>
            <div>
            <form method="post">
                Код подтверждения:<br>
                <input type="text" class="form-control" name="emailcode"><br>
                <button class="btn btn-success" name="confirmbut">Подтвердить</button> <button class="btn btn-secondary">Выйти</button><br>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    scnds = document.getElementById('prov').value
    if(scnds < 120)
    {
        scnds = 120 - scnds
        tim = setInterval(function()
        {
            scnds = scnds - 1
            if(scnds<=0)
            {
                $('#schet').html('Обновите страницу для повторной отправки письма.')
                clearInterval(tim)
            }
            else
            {
                $('#schet').html('Если вам не пришло письмо, перезагрузите страницу через '+scnds+' секунд.')
            }
        },1000)
    }
</script>