<?php
    date_default_timezone_set("America/Toronto");
    $name = isset($_POST['person']) ? $_POST['person'] : '';
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $error = 0;

    require_once( 'shared/connect.php' );

    if($name!= ''){

        $sql2 = "select timeIn from clock where name = '$name' and date = '$date' and timeOut IS null";
        $sth = $dbh->prepare( $sql2 );
        $sth->execute();
        $available = $sth->fetchAll();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $sql = "update clock set timeOut = '$time'where name= '$name' and timeOut IS null";
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

    $sqlEmp = "select * from employees";
    $sthEmp = $dbh->prepare($sqlEmp);
    $sthEmp->execute();
    $availEmp = $sthEmp->fetchAll();
    $empCount = $sthEmp->rowCount();

    $time = date('g:i A',strtotime($time));

    $dbh=null;




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
        <form action="/clockapp/clockout.php" method="post" value="in">
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
                    <button type="submit" value="submit" class="btn btn-dark btn-block btn-lg">Clock Out</button>
                </div>
            </div>
        </form>
        <br>
        <h6 class="text-center">
            <?php
            if($name != '' &&  $error == 0) {
                foreach ($available as $avail ) {
                    echo $avail['name'] . " clocked out on " . $avail['date'] . " at " . $time;
                }
            }
            if ($error!=0){
                echo 'Clock Out not valid!';
            }
            ?>
        </h6>
    </div>
</div>
</div>
    <?php include 'footer.php'; ?>
</body>

</html>
