<?php

    if (isset($_POST['store']) && $_POST['store'] != ''){
        setcookie('store', $_POST['store'], time() + (86400 * 30 * 12), "/");
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
        <form action="/clockapp/selectstore" method="post" value="in">
            <div class="form-group">
                <select class="form-control" name="store">
                    <option value="">Select Store</option>
                    <option value="albion">Albion</option>
                    <option value="markham">Markham</option>
                    <option value="mountainash">Mountainash</option>
                    <option value="rutherford">Rutherford</option>
                    <option value="wolfedale">Wolfedale</option>
                </select>
            </div>
            <br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
                <div class="row p-1">
                    <button type="submit" value="submit" class="btn btn-dark btn-block btn-lg">Select</button>
                </div>
            </div>
        </form>
        <br>
        <h6 class="text-center">
            <?php
                if (isset($_COOKIE['store'])){
                    echo strtoupper($_COOKIE['store']. " selected");
                }
            ?>
        </h6>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>

</html>