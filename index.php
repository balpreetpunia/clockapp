
<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="jumbotron" >
        <div class="card card-body bg-light col-lg-4 col-xs-12 offset-lg-4 text-center border border-dark">
            <div class="">
                <br>
                <img class="img-responsive" src="tlogo.png">
            </div>
            <br><hr><br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
            <div class="row p-1">
                <a href="/clockapp/clockin.php" class="btn btn-dark btn-block btn-lg" role="button">Clock In</a>
            </div>
            <div class="row p-1">
                <a href="/clockapp/clockout.php" class="btn btn-dark btn-block btn-lg" role="button">Clock Out</a>
            </div>
            <div class="row p-1">
                <a href="/clockapp/break.php" class="btn btn-dark btn-block btn-lg" role="button">Break</a>
            </div>
            <div class="row p-1">
                <a href="/clockapp/manage.php" class="btn btn-dark btn-block btn-lg" role="button">Manage</a>
            </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>
