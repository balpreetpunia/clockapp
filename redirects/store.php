<?php
    if(!isset($_COOKIE['store'])){
    header('Location: /clockapp/selectstore');
    exit();
    }
