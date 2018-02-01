<?php
    if(!isset($_COOKIE['login'])){
    header('Location: /clockapp/');
    exit();
}
