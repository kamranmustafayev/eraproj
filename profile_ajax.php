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
                <h3 class="card-title text-center">@<?php echo $uinfo['username']; ?></h3>
                <p></p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-profile goperson"><div class="col text-start goperson" id="<?php echo $uinfo['id']; ?>"><i class="bi bi-person"></i> Full Profile</div></li>
                    <li class="list-group-item list-profile gofriends"><div class="row"><div class="col text-start"><i class="bi bi-person"></i> Friends</div><div class="col text-end"></div></div></li>
                    <li class="list-group-item list-profile"><div class="col text-start"><i class="bi bi-person"></i> Posts</div></li>
                    <li class="list-group-item list-profile"><div class="col text-start"><i class="bi bi-person"></i> Groups</div></li>
                    <li class="list-group-item list-profile"><div class="col text-start"><i class="bi bi-person"></i> Photos</div></li>
                    <li class="list-group-item list-profile"><div class="col text-start"><i class="bi bi-person"></i> Notifications</div></li>
                    <li class="list-group-item list-profile"><div class="col text-start"><i class="bi bi-person"></i> Settings</div></li>
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