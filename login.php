<?php

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $error = 0;

    if($username != '' && $password != ''){

        require_once( 'shared/connect.php' );

        $sql = "select * from admin where username = '$username' and password = '$password'";
        $sth = $dbh->prepare( $sql );
        $sth->execute();
        $available = $sth->fetchAll();
        $count = $sth->rowCount();

        if ($count > 0){
            setcookie('login', true, 0, "/");
            header('Location: /clockapp/');
            exit();
        }
        else{
            $error = 1;
        }
    }


?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
<?php include 'nav.php'; ?>
<div class="jumbotron ">
    <div class="card card-body bg-light col-lg-4 col-xs-12 offset-lg-4 text-center border border-dark">
        <div class="">
            <br>
            <a href="/clockapp/"><img class="img-responsive" src="tlogo.png"></a>
        </div>
        <br><hr><br>
        <form action="/clockapp/login" method="post" value="in">
            <div class="form-group">
                <input class="form-control" name="username" placeholder="Username" type="text">
            </div>
            <div class="form-group">
                <input class="form-control" name="password" placeholder="Password" type="password">
            </div>
            <br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
                <div class="row p-1">
                    <button type="submit" value="submit" class="btn btn-dark btn-block btn-lg">Sign In</button>
                </div>
            </div>
        </form>
        <br>
        <?php
        if($error == 1) {
            echo '<div class="alert alert-danger" role="alert">Invalid Credentials!</div>';
        }
        ?>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>

</html>