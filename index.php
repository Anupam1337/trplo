<?php

// verify the user using token
if (isset($_GET['token']) && isset($_GET['emailid'])) {
    $token = $_GET['token'];
    $emailid = $_GET['emailid'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="TRPLO OFfficial Website">
    <meta name="keywords" content="TRPLO Corporation">
    <meta name="author" content="Anupam Mishra">

    <title>TRPLO</title>

    <!-- Bootstrap CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="./assets/js//jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="./assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    -->

</head>

<body>
    <p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a>!</p>

    <?php
    if (isset($_SESSION['id'])) {
    ?>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['alert-class']);
                ?>
                <?php if (count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <!-- You are now logged in -->
            </div>
    <?php endif;
    } ?>

    <ul class="nospace">
        <li><a href="index.php"><?php if (isset($_SESSION['username'])) {
                                    echo "Hello, " . $_SESSION['username'] . " ";
                                } ?><i class="fas fa-home"></i></a></li>
        <li><a href="help.php" title="Help Centre">Help</i></a></li>
        <?php if (isset($_SESSION["verified"])) { ?>
            <li><a href="index.php?logout=1" title="Logout"> Logout</i></a> </li> <?php
                                                                                } else { ?> <li><a href="login.php" title="Login">Login</i></a></li>
            <li><a href="signup.php" title="Sign Up">Signup</i></a></li>
        <?php } ?>
    </ul>

    <ul class="clear">
        <li class="active"><a href="index.php">Home</a></li>
    </ul>

    <a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
</body>

</html>