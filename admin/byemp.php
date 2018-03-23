<?php

    date_default_timezone_set("America/Toronto");

    require_once( '../shared/connect.php' );

    $search = isset($_POST['name']) ? $_POST['name'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : 'name';
    $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
    $dateStart = isset($_POST['dateStart']) ? $_POST['dateStart'] : $date;
    $dateEnd = isset($_POST['dateEnd']) ? $_POST['dateEnd'] : '';
    $store = $_COOKIE['store'];
    $count = 0;
    $totalHours = 0;
    $error = 0;


    if($search == '' ){
        $error =1;
    }

    elseif($search != ''){
        if(!empty($_POST['dateStart']) && !empty($_POST['dateEnd']))
        {
            $sql = "select * from clock where name = '$search' and store = '$store' and date between '$dateStart' and '$dateEnd' ";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $available = $sth->fetchAll();
            $count = $sth->rowCount();
        }
        else
        {
            $error = 2;
        }

    }


    $sqlEmp = "select * from employees where store = '$store'";
    $sthEmp = $dbh->prepare($sqlEmp);
    $sthEmp->execute();
    $availEmp = $sthEmp->fetchAll();
    $empCount = $sthEmp->rowCount();

    $dbh=null;
?>


<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php include '../head.php'; ?>
</head>

<body>
<?php include '../nav.php'; ?>
<div class="jumbotron ">
    <div class="card card-body bg-light col-lg-8 col-xs-12 offset-lg-2 text-center border border-dark">
        <div class="">
            <br>
            <a href="/clockapp/"><img class="img-responsive" src="/clockapp/tlogo.png"></a>
            <br>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-3">
                <h6 class="mt-4 text-left">
                    <?php
                        if($search == '')
                            {echo 'Select Name';}
                        else
                            { echo strtoupper($search);}
                    ?>
                </h6>
            </div>
            <div class="col-lg-9 lg-auto d-flex justify-content-end">
                <form class="form-inline" method="post" action="/clockapp/admin/byemp">
                    <div class="input-group mb-3">
                        <input class="form-control" id="dateStart" type="date" name="dateStart">
                        <input class="form-control" id="dateEnd" type="date" name="dateEnd">
                        &nbsp;
                        <div class="input-group-append">
                            <select class="form-control" name="name" id="name">
                                <option value="">Select Name</option>
                                <?php foreach ($availEmp as $emp): ?>
                                    <option value="<?= $emp['name'] ?>"><?= $emp['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <button class="btn btn-outline-secondary" type="submit" value="Submit">
                                <span class="fa fa-search" aria-hidden="true"></span>&zwnj;
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($count > 0): ?>
            <table class="table table-striped table-bordered table-responsive-sm">
                <thead>
                <tr>
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
                            $hours = 0;

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
                            $totalHours += $hours;
                            ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-5 text-left">
                    <a href="/clockapp/admin/bydate" ><h6>By Date</h6></a>
                </div>
                <div class="col-7">
                    <h6 class="text-right">Total Hours: <?= round($totalHours,2) ?></h6>
                </div>
            </div>
        <?php else: ?>
        <hr>
        <div class="row">
            <div class="col-lg-3 col-sm-12 text-left">
                <a href="/clockapp/admin/bydate" ><h6 class="mt-3">By Date</h6></a>
            </div>
            <div class=" offset-lg-2 col-lg-6 alert alert_warning">
                <h6 class="text-left">
                    <?php
                        if($error == 1)
                        {
                          echo 'No information, Select Name' ;
                        }
                        elseif ($error == 2)
                        {
                            echo 'No information, Select Date Range.' ;
                        }
                        else
                        {
                            echo 'No information to display.' ;
                        }
                    ?>
                </h6>
            </div>
        </div>
        <?php endif ?>


    </div>
</div>
<?php include '../footer.php'; ?>
<script>
    <?php if(isset($dateStart)&&isset($dateEnd)): ?>
    document.getElementById("dateStart").valueAsDate =  <?= "new Date('$dateStart')" ?>;
    document.getElementById("dateEnd").valueAsDate =  <?= "new Date('$dateEnd')" ?>;
    <?php else: ?>
    document.getElementById("dateEnd").valueAsDate =  new Date();
    <?php endif; ?>
    document.getElementById("name").value = <?="'$search'"?>;
</script>
</body>

</html>

