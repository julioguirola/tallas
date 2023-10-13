<?php

    require_once 'pdo.php';
    session_start();


    if ($_SESSION['user']['id'] == $_GET['uid'] || $_SESSION['user']['id'] == 6){
        $stmt = $pdo->query("delete from tallas where talla_id=".$_GET['id']);
    }


    header("Location: mainpage.html");
    return;
?>