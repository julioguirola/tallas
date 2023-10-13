<?php
    require_once 'pdo.php';
    session_start();

    $stmt = $pdo->prepare("insert into who_about (name) values (:nm)");
    $stmt->execute(array(':nm' => $_SESSION['user']['name']));