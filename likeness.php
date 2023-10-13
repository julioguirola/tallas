<?php
    require_once 'pdo.php';
    session_start();

    $stmt = $pdo->prepare("select * from who where tallaid = :ti and userid = :ui");
    $stmt->execute(array(':ti' => $_POST['tallaid'], ':ui' => $_SESSION['user']['id']));
    $like = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($like) == 0) {

        switch ($_POST['likeness']) {
            case 'like':
                $stmt = $pdo->prepare("insert into who (tallaid, userid, like_, dislike_) values (:ti, :ui, :lk, :dk)");
                $stmt->execute(array(':ti' => $_POST['tallaid'], ':ui' => $_SESSION['user']['id'], ':lk' => 1, ':dk' => 0));
                break;
            
            case 'dislike':
                $stmt = $pdo->prepare("insert into who (tallaid, userid, like_, dislike_) values (:ti, :ui, :lk, :dk)");
                $stmt->execute(array(':ti' => $_POST['tallaid'], ':ui' => $_SESSION['user']['id'], ':lk' => 0, ':dk' => 1));            
                break;
        }
    } else {
        switch ($_POST['likeness']) {
            case 'like':
                $stmt = $pdo->prepare("UPDATE who SET like_ = like_ + 1, dislike_ = 0 WHERE tallaid = :ti and userid = :ui");
                $stmt->execute(array(':ti' => $_POST['tallaid'], ':ui' => $_SESSION['user']['id']));
                break;
            
            case 'dislike':
                $stmt = $pdo->prepare("UPDATE who SET like_ = 0, dislike_ = dislike_ + 1 WHERE tallaid = :ti and userid = :ui");
                $stmt->execute(array(':ti' => $_POST['tallaid'], ':ui' => $_SESSION['user']['id']));
                break;
        }
    }

    