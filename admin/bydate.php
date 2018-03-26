<?php
    session_start();
    date_default_timezone_set("America/Toronto");

    require_once( '../shared/connect.php' );

    $store = $_COOKIE['store'];
    $date = date('Y-m-d');

    if (isset($_POST['plus'])){
        if(isset($_SESSION['date'])){
            $date = $_SESSION['date'];
        }
        $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $_SESSION['date'] = $date;
    }

    else if (isset($_POST['minus'])){
        if(isset($_SESSION['date'])){
            $date = $_SESSION['date'];
        }
        $date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $_SESSION['date'] = $date;
    }

    else if(isset($_POST['date']) && $_POST['date'] != ''){
        $date = $_POST['date'];
        $_SESSION['date'] = $date;
    }


$sql = "select * from clock where date = '$date' and store = '$store'";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $available = $sth->fetchAll();
    $count = $sth->rowCount();

    $dbh=null;
?>


<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php include '../head.php'; ?>
</head>

<body>
<?php include '../nav.php'; ?>
<div class="jumbotron">
    <div class="card card-body bg-light col-lg-8 col-xs-12 offset-lg-2 text-center border border-dark">
        <div class="">
            <br>
            <a href="/clockapp/"><img class="img-responsive" src="/clockapp/tlogo.png"></a>
            <br>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4">
                <h6 class="mt-4 text-left">Date: <?= $date ?> </h6>
            </div>
        <div class="col-lg-9 col-md-9 col-sm-8 d-flex justify-content-end">
            <form class="form-inline" method="post" action="/clockapp/admin/bydate">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" type="submit" name="minus" value="minus"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;</button>&nbsp;
                    <button class="btn btn-outline-secondary" type="submit" name="plus" value="plus">&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button>&nbsp;
                    <input class="form-control" style="width:180px;"  id="date" type="date" name="date">

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" value="Submit">
                            <i class="fa fa-search" aria-hidden="true"></i>&zwnj;
                        </button>

                    </div>
                </div>
            </form>
        </div>
        </div>

        <?php if ($count > 0): ?>
        <div class="table-responsive-sm">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Date</td>
                    <td>Time In</td>
                    <td>Break Start</td>
                    <td>Break End</td>
                    <td>Time Out</td>
                    <td>Hours</td>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($available as $avail ): ?>
                    <tr>
                        <td class="text-left"><?= $avail['name'] ?></td>
                        <td><?= $avail['date'] ?></td>
                        <td>
                            <?php
                                if($avail['timeIn'] != null)
                                {
                                    echo date('g:i A',strtotime($avail['timeIn']));
                                }
                                else echo $avail['timeIn'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if($avail['breakStart'] != null)
                            {
                                echo date('g:i A',strtotime($avail['breakStart']));
                            }
                            else echo $avail['breakStart'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if($avail['breakEnd'] != null)
                            {
                                echo date('g:i A',strtotime($avail['breakEnd']));
                            }
                            else echo $avail['breakEnd'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if($avail['timeOut'] != null)
                            {
                                echo date('g:i A',strtotime($avail['timeOut']));
                            }
                            else echo $avail['timeOut'];
                            ?>
                        </td>
                        <td><?php
                            $start = $avail['timeIn'];
                            $end = $avail['timeOut'];
                            $bStart = $avail['breakStart'];
                            $bEnd = $avail['breakEnd'];

                                if($avail['breakEnd'] == null && $avail['breakStart'] == null && $avail['timeOut'] != null)
                                {
                                    $hours = (strtotime($end) - strtotime($start))/3600;
                                    echo round($hours,2);
                                }
                                elseif ($avail['breakEnd'] != null && $avail['breakStart'] != null && $avail['timeOut'] != null)
                                {
                                    $bHours = (strtotime($bEnd) - strtotime($bStart))/3600;
                                    $tHours = (strtotime($end) - strtotime($start))/3600;

                                    $hours = round(($tHours-$bHours),2);
                                    echo $hours;
                                }
                            ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12 text-left">
                <a href="/clockapp/admin/byemp" ><h6>By Employee</h6></a>
            </div>
        </div>
        <?php else: ?>
        <hr>
        <div class="row">
            <div class="col-lg-3 col-sm-12 text-left">
                <a href="/clockapp/admin/byemp" ><h6 class="mt-3">By Employee</h6></a>
            </div>
            <div class=" offset-lg-2 col-lg-6 alert alert_warning">
                <h6 class="text-left">No Information to display</h6>
            </div>
        </div>
        <?php endif ?>


    </div>
</div>
<?php include '../footer.php'; ?>
<script>
    document.getElementById("date").valueAsDate =  <?= "new Date('$date')" ?>;
</script>
</body>

</html>

