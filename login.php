<?php
    require_once 'core/init.php';
    $validate = new Validate();
    $validation = new Validate();

    if(Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'name'          => 'Username',
                    'required'      => true
                ),
                'password' => array(
                    'name'          => 'Password',
                    'required'      => true
                )
            ));
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <script src="https://web.freshchat.com/js/widget.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<div>
        <?php
        if ($validation->passed() === true) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login) {
                Redirect::to('index.php');
            } else {
                ?>
                <script>
                    $(window).on('load', function() {
                        $('#myModal-login').modal('show');
                    });
                </script>
                <div class="modal fade" id="myModal-login">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Errors</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" role="alert">
                                    <p>Sorry, logging in failed.</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            if(count($validation->errors())) {
            ?>
                <script>
                    $(window).on('load', function() {
                        $('#myModal-Failure').modal('show');
                    });
                </script>
                <div class="modal fade" id="myModal-Failure">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Errors</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                foreach ($validation->errors() as $error) {
                                    echo '<div class="alert alert-danger" role="alert">';
                                    echo $error, '<br>';
                                    echo "</div>";
                                }
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
    <div class="row" style="margin: 0">
        <div class="col-sm-0 col-lg-3">
        </div>
        <div class="col-sm-12 col-lg-6" style="padding: 0px">
            <div class="jumbotron" style="margin-bottom: 0;">
                <h1 class="text-center">TRPLO</h1>

                <form action="" method="post">
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="username" value="<?php echo escape(Input::get('username')); ?>" name="username" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control form-control-sm" id="password" name="password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-check row">
                        &nbsp;&nbsp;&nbsp;
                        <input type="checkbox" class="form-check-input form-control-sm checkbox" id="remember" name="remember" style="margin-top: 0.05rem">
                        <label class="col-form-label col-form-label-sm form-check-label" for="remeber"> Remember me</label>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <button type="submit" class="btn btn-success" value="Register">Log in</button>
                    </div>
                </form>
                <p class="text-center">Not yet a member? <a href="register.php">Sign up</a></p>
            </div>
        </div>
        <div class="col-sm-0 col-lg-3">
        </div>
    </div>

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