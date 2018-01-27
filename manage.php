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
                <a href="/clockapp/"><img class="img-responsive" src="tlogo.png"></a>
            </div>
            <br><hr><br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
                <div class="row p-1">
                    <a href="/clockapp/manage/bydate.php" class="btn btn-dark btn-block btn-lg" role="button">View by Date</a>
                </div>
                <div class="row p-1">
                    <a href="/clockapp/manage/byemp.php" class="btn btn-dark btn-block btn-lg" role="button">View by Employee</a>
                </div>
                <div class="row p-1">
                    <a href="/clockapp/manage/addemp.php" class="btn btn-dark btn-block btn-lg disabled" role="button">Add Employee</a>
                </div>
                <div class="row p-1">
                    <a href="/clockapp/manage/removeemp.php" class="btn btn-dark btn-block btn-lg disabled" role="button">Remove Employee</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    </body>

</html>