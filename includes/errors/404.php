<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - ePUBG</title>
</head>
<body>
    <?php
        if(Session::exists('error')) {
            echo '<p>' . Session::flash('error') . '<p>';
        }        
    ?>
    <h1>404 - Page Not Found</h1>
    <p>Oops, that page can't be found!</p>
    <p>Go to Home</p>
    <a href="../../index.php"><button>Home</button></a>
</body>
</html>