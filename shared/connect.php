<?php

    try{
        $dbh = new PDO( "mysql:host=localhost;dbname=clockapp", "root", "" );
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $e){
        echo 'Database connection failed: ' . $e->getMessage();
    }

    ?>