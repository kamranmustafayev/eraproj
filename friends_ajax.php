<?php
include('inc/sescheck.php');

?>
<body>
    <br><br>
<div class="container">
    <br>
    <div class="text-center">
        <div class="card card-op">
            <div class="card-body text-start">
                <h3 class="card-title text-start">Friends</h3>
                <p></p>
                <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                    <li class="flex-sm-fill nav-item" role="presentation">
                        <button class="nav-link active" id="pills-friends-tab" data-bs-toggle="pill" data-bs-target="#pills-friends" type="button" role="tab" aria-controls="pills-friends" aria-selected="true">Друзья</button>
                    </li>
                    <li class="flex-sm-fill nav-item" role="presentation">
                        <button class="nav-link" id="pills-comings-tab" data-bs-toggle="pill" data-bs-target="#pills-comings" type="button" role="tab" aria-controls="pills-comings" aria-selected="false">Запросы</button>
                    </li>
                    <li class="flex-sm-fill nav-item" role="presentation">
                        <button class="nav-link" id="pills-find-tab" data-bs-toggle="pill" data-bs-target="#pills-find" type="button" role="tab" aria-controls="pills-find" aria-selected="false">Поиск</button>
                    </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-friends" role="tabpanel" aria-labelledby="pills-friends-tab">
                    <ul class="list-group list-group-flush ppl">
                        <?php
                        $check = mysqli_query($con,"SELECT accounts.id,accounts.username,accounts.foto FROM accounts,friends WHERE 
                        (friends.senderid='".$uinfo['id']."' OR friends.receiverid='".$uinfo['id']."') 
                        AND (accounts.id=friends.senderid OR accounts.id=friends.receiverid) 
                        AND friends.checked='2' AND accounts.id!='".$uinfo['id']."' 
                        GROUP BY username ASC");
                        if(mysqli_num_rows($check) > 0)
                        {
                            while($info = mysqli_fetch_array($check))
                            {
                                echo '
                            <li class="list-group-item clearfix goperson" id="'.$info['id'].'">
                                <img src="'.$info['foto'].'" alt="avatar">
                                <div class="about">
                                <div class="name">'.$info['username'].'</div>
                                </div>
                            </li>';
                            }
                        }
                        else
                        {
                            echo 'You do not have any friend';
                        }
                        ?>
                    </ul>
                    </div>
                    <div class="tab-pane fade" id="pills-comings" role="tabpanel" aria-labelledby="pills-comings-tab">
                    <ul class="list-group list-group-flush ppl">
                        <?php
                        $check = mysqli_query($con,"SELECT accounts.id,accounts.username,accounts.foto FROM accounts,friends WHERE 
                        (friends.senderid='".$uinfo['id']."' OR friends.receiverid='".$uinfo['id']."') 
                        AND (accounts.id=friends.senderid OR accounts.id=friends.receiverid) 
                        AND friends.checked!='2' AND accounts.id!='".$uinfo['id']."' 
                        GROUP BY username ASC");
                        if(mysqli_num_rows($check) > 0)
                        {
                            while($info = mysqli_fetch_array($check))
                            {
                                echo '
                            <li class="list-group-item clearfix goperson" id="'.$info['id'].'">
                                <img src="'.$info['foto'].'" alt="avatar">
                                <div class="about">
                                <div class="name">'.$info['username'].'</div>
                                </div>
                            </li>';
                            }
                        }
                        else
                        {
                            echo 'You do not have any friend';
                        }
                        ?>
                    </ul>
                    </div>
                    <div class="tab-pane fade" id="pills-find" role="tabpanel" aria-labelledby="pills-find-tab">
                        <br>
                            <input type="text" class="form-control" id="finduser" placeholder="Username or ID"><br>
                            <button class="form-control btn btn-outline-light findbut">Search</button>
                        <br>
                        <?php
                        if(!empty($_POST['finduser']))
                        {
                            echo '<ul class="list-group list-group-flush ppl">';
                            $check = mysqli_query($con,"SELECT id,username,foto FROM accounts WHERE username LIKE '%".$finduser."%' OR id='".$finduser."'");
                            if(mysqli_num_rows($check) > 0)
                            {
                                while($info = mysqli_fetch_array($check))
                                {
                                    echo '
                                <li class="list-group-item clearfix goperson">
                                    <img src="'.$info['foto'].'" alt="avatar">
                                    <div class="about">
                                    <div id="userid" class="name" uid="'.$info['id'].'">'.$info['username'].'</div>
                                    </div>
                                </li>';
                                }
                            }
                            else
                            {
                                echo 'You do not have any friend';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                </div>
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
        <span class="bnav_text">Feed</span>
    </a>
    <a href="#" class="bnav_link chatsbut">
        <i class="material-icons bnav_icon">chat</i>
        <span class="bnav_text">Messages</span>
    </a>
    </nav>
</body>
</html>