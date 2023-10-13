<?php

    session_start();
    date_default_timezone_set('America/Havana');
    require_once 'pdo.php';

    $stmt = $pdo->prepare("INSERT INTO tallas (id, date_, talla) VALUES (:id, :dt, :tl)");
    $stmt->execute(array(":id" => $_SESSION["user"]['id'], ":dt" => date('d/m/Y h:i:s'), 'tl' => $_POST['talla']));
     
