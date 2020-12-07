<?php
    require_once 'core/init.php';

    $user = new User();
    if(!$username = Input::get('user')) {
        Redirect::to('index2.php');
    } else {
        $user = new User($username);
        if(!$user->exists()) {
            Redirect::to(404);
        } else {
            $data = $user->data();
        }
?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $username;?> - ePUBG</title>
        <script src="https://web.freshchat.com/js/widget.js"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    </head>

    <body style="padding: 10px">

    <?php
        if($user->isLoggedIn()) {
    ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index2.php">ePUBG</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                    <a class="nav-link" href="index2.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                            if($data->profilepicture !== '') {
                            ?>
                            <img src="profilepictures/<?php echo escape($user->data()->profilepicture);?>" style="height: 40px; width: 40px; border-radius: 50%">
                            <?php
                            }
                            echo $user->data()->fname." ";
                            echo $user->data()->lname;
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="update.php">Update Profile</a>
                            <a class="dropdown-item" href="changepassword.php">Change Password</a>
                            <a class="dropdown-item" href="logout.php">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <?php } ?>
    <h3>
    <?php

        if($data->profilepicture !== '') {
        ?>
            <img src="profilepictures/<?php echo escape($data->profilepicture);?>" style="height: 40px; width: 40px; border-radius: 50%">
        <?php 
        } ?>
        
        <?php echo escape($data->username);?>
        <?php
            $user2 = new User();
            if($user->isLoggedIn() && strcasecmp($user2->data()->username, $username) === 0) {
                ?>
                <button class="btn btn-success" style="float: right"><a href="update.php" style="color: white; text-decoration: none">Update Profile</a></button>
                <?php
            }
        }
        ?>
        </h3>
        <p>First Name: <?php echo escape($data->fname);?></p]>
        <p>Last Name: <?php echo escape($data->lname);?></p]>
        <?php
            if($user2->isLoggedIn() && strcasecmp($user2->data()->username, $username) === 0) {
            ?>
                <p>Email: <?php echo escape($data->email);?></p]>
                <p>Referail ID: <?php echo escape($data->referalid);?></p]>
            <?php
            } ?>
        <p>PUBG ID: <?php echo escape($data->pubgid);?></p]>

    </body>
    <script>
        function initFreshChat() {
            window.fcWidget.init({
                token: "6c00161d-7b41-4cd5-a2eb-c0ee52f20e73",
                host: "https://wchat.freshchat.com"
            });
        }

        function initialize(i, t) {
            var e;
            i.getElementById(t) ? initFreshChat() : ((e = i.createElement("script")).id = t,
                e.async = !0,
                e.src = "https://wchat.freshchat.com/js/widget.js",
                e.onload = initFreshChat,
                i.head.appendChild(e))
        }

        function initiateCall() {
            initialize(document, "freshchat-js-sdk")
        }
        window.addEventListener ? window.addEventListener("load", initiateCall, !1) : window.attachEvent("load", initiateCall, !1);
        // Copy the below lines under window.fcWidget.init inside initFreshChat function in the above snippet

        // To set unique user id in your system when it is available
        window.fcWidget.setExternalId("john.doe1987");

        // To set user name
        window.fcWidget.user.setFirstName("John");

        // To set user email
        window.fcWidget.user.setEmail("john.doe@gmail.com");

        // To set user properties
        window.fcWidget.user.setProperties({
            plan: "Estate", // meta property 1
            status: "Active" // meta property 2
        });
    </script>

</html>