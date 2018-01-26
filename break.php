<?php
    date_default_timezone_set("America/Toronto");
    $name = isset($_POST['person']) ? $_POST['person'] : '';
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $error = 0;

    $dbh = new PDO( "mysql:host=localhost;dbname=clockapp", "root", "" );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    if($name!= '' && isset($_POST['start_button'])){

        $sql2 = "select timeIn from clock where name = '$name' and date = '$date' and timeOut IS null and breakStart is null";
        $sth = $dbh->prepare( $sql2 );
        $sth->execute();
        $available = $sth->fetchAll();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $sql = "update clock set breakStart = '$time'where name= '$name' and timeOut IS null and breakStart is null";
            $dbh->exec($sql);

            $sql2 = "select * from clock where name = '$name' and date = '$date'";
            $sth = $dbh->prepare( $sql2 );
            $sth->execute();
            $available = $sth->fetchAll();
        }
        else
        {
            $error = 1;
        }
    }

    else if($name!= '' && isset($_POST['end_button'])){

        $sql2 = "select timeIn from clock where name = '$name' and date = '$date' and timeOut IS null and breakStart is not null and breakEnd is null";
        $sth = $dbh->prepare( $sql2 );
        $sth->execute();
        $available = $sth->fetchAll();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $sql = "update clock set breakEnd = '$time'where name= '$name' and timeOut IS null and breakStart is not null and breakEnd is null";
            $dbh->exec($sql);

            $sql2 = "select * from clock where name = '$name' and date = '$date'";
            $sth = $dbh->prepare( $sql2 );
            $sth->execute();
            $available = $sth->fetchAll();
        }
        else
        {
            $error = 2;
        }
    }

    $sqlEmp = "select * from employees";
    $sthEmp = $dbh->prepare($sqlEmp);
    $sthEmp->execute();
    $availEmp = $sthEmp->fetchAll();
    $empCount = $sthEmp->rowCount();

    $time = date('g:i A',strtotime($time));

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
<nav class="navbar navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="/clockapp/">CLOCK APP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/clockin.php">Clock In<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/clockout.php">Clock Out</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/clockapp/break.php">Break</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/manage.php">Manage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/manage/bydate.php">View By Date</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/manage/byemp.php">View By Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/manage/addemp.php">Add Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clockapp/manage/removeemp.php">Remove Employee</a>
            </li>
        </ul>
    </div>
</nav>
<div class="jumbotron ">
    <div class="card card-body bg-light col-lg-4 col-xs-12 offset-lg-4 text-center border border-dark">
        <div class="">
            <br>
            <a href="/clockapp/"><img class="img-responsive" src="tlogo.png"></a>
        </div>
        <br><hr><br>
        <form action="/clockapp/break.php" method="post" value="in">
            <div class="form-group">
                <select class="form-control" name="person" id="exampleFormControlSelect1">
                    <option value="">Select Name</option>
                    <?php foreach ($availEmp as $emp): ?>
                        <option value="<?= $emp['name'] ?>"><?= $emp['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
                <div class="row p-1">
                    <button type="submit" name="start_button" value="start" class="btn btn-dark btn-block btn-lg">Start Break</button>
                    <button type="submit" name="end_button" value="end" class="btn btn-dark btn-block btn-lg">End Break</button>
                </div>
            </div>
        </form>
        <br>
        <h6 class="text-center">
            <?php
            if($name != '' &&  $error == 0 && isset($_POST['start_button'])) {
                foreach ($available as $avail ) {
                    echo $avail['name'] . " started break on " . $avail['date'] . " at $time";
                }
            }
            elseif($name != '' &&  $error == 0 && isset($_POST['end_button'])) {
                foreach ($available as $avail ) {
                    echo $avail['name'] . " ended break on " . $avail['date'] . " at $time";
                }
            }
            if($error==1)
            {
                echo 'Start Break not valid!';
            }
            else if($error==2)
            {
                echo 'End Break not valid!';
            }
            ?>
        </h6>
    </div>
</div>
</div>



</body>

</html>
