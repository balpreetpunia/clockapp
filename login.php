<?php
    if(isset($_POST['username'])){
        setcookie('login', true, 0, "/");
        header('Location: /clockapp/');
        exit();
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
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>

</html>