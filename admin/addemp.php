<?php

    require_once( '../redirects/permission.php' );
    require_once( '../shared/connect.php' );

    $name = isset($_POST['person']) ? $_POST['person'] : '';
    $name = ucfirst(strtolower($name));
    $store = $_COOKIE['store'];
    $error = 0;



    if($name!= ''){

        $sql2 = "select name from employees where name = '$name' and store = '$store'";
        $sth = $dbh->prepare( $sql2 );
        $sth->execute();
        $available = $sth->fetchAll();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $error = 1;
        }
        else
        {
            $sql = "INSERT INTO employees (name, store) VALUES ('$name','$store')";
            $dbh->exec($sql);
        }
    }

    $sqlEmp = "select * from employees";
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
    <div class="card card-body bg-light col-lg-4 col-xs-12 offset-lg-4 text-center border border-dark">
        <div class="">
            <br>
            <a href="/clockapp/"><img class="img-responsive" src="/clockapp/tlogo.png"></a>
        </div>
        <br><hr><br>
        <form action="/clockapp/admin/addemp" method="post" value="in">
            <div class="form-group">
                <input class="form-control" name="person" type="text" placeholder="Enter Name">
            </div>
            <br>
            <div class="col-lg-6 col-xs-12 offset-lg-3">
                <div class="row p-1">
                    <button type="submit" value="submit" class="btn btn-dark btn-block btn-lg">Add</button>
                </div>
            </div>
        </form>
        <br>
        <h6 class="text-center">
            <?php
            if($name != '' &&  $error == 0)
            {
                echo "$name added to employee list";
            }
            elseif($error == 1){
                echo 'Add not valid!';
            }
            ?>
        </h6>
    </div>
</div>
</div>
<?php include '../footer.php'; ?>
</body>

</html>