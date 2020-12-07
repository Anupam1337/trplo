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
                    'required'      => true,
                    'min'           => 5,
                    'max'           => 20,
                    'pattern'       => 'username',
                    'unique'        => 'users',
                    'uniqueness'    => 'username'
                ),
                'email' => array(
                    'name'          => 'Email',
                    'required'      => true,
                    'min'           => 7,
                    'pattern'       => 'email',
                    'unique'         => 'users',
                    'uniqueness'    => 'email'
                ),
                'password' => array(
                    'name'          => 'Password',
                    'required'      => true,
                    'min'           => 6
                ),
                'password_again' => array(
                    'name'          => 'Confirm Password',
                    'matches_name'  => 'Password',
                    'required'      => true,
                    'matches'       => 'password'
                ),
                'firstname' => array(
                    'name'          => 'First Name',
                    'required'      => true,
                    'min'           => 2,
                    'max'           => 50,
                    'pattern'       => 'name'
                ),
                'lastname' => array(
                    'name'          => 'Last Name',
                    'required'      => true,
                    'min'           => 2,
                    'max'           => 50,
                    'pattern'       => 'name'
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
    <title>Register - TRPLO</title>
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

            $token = bin2hex(random_bytes(50));
            $referalid = Hash::referalid(Input::get('firstname'), Input::get('lastname'));
            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'username'      => Input::get('username'),
                    'fname'         => Input::get('firstname'),
                    'lname'         => Input::get('lastname'),
                    'email'         => Input::get('email'),
                    'token'         => $token,
                    'password'      => Hash::make(Input::get('password'), $salt),
                    'group'         => 1
                ));

                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to('index.php');
            } catch(Exception $e) {
                die($e->getMessage());
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
            <div class="jumbotron" style="margin-bottom: 0">
                <h1 class="text-center">TRPLO</h1>

                <form action="" method="post">
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="username" value="<?php echo escape(Input::get('username')); ?>" aria-describedby="usernameHelp" name="username">
                            <small id="usernameHelp" class="form-text text-muted">Username must be unique containing A-Z, a-z or 0-9 characters only.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" value="<?php echo escape(Input::get('email')); ?>" aria-describedby="emailHelp" name="email">
                            <small id="emailHelp" class="form-text text-muted">Verify email ID. You can only access your account in case you forget creditentials</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label col-form-label-sm">Your Name</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" value="<?php echo escape(Input::get('firstname')); ?>" placeholder="First Name">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" value="<?php echo escape(Input::get('lastname')); ?>" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control form-control-sm" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirmpassword" class="col-sm-2 col-form-label col-form-label-sm">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control form-control-sm" id="confirmpasword" name="password_again">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group form-check row">
                        &nbsp;&nbsp;&nbsp;
                        <input type="checkbox" class="form-check-input form-control-sm checkbox" id="exampleCheck1" name="terms" required>
                        <label class="col-form-label col-form-label-sm form-check-label" for="exampleCheck1">Terms & Conditions</label>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <button type="submit" class="btn btn-success" value="Register">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-0 col-lg-3">
        </div>
    </div>

</body>

</html>