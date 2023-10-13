<?php
    session_start();
    require_once 'pdo.php';

    $stmt = $pdo->query("select email from users");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $used = false;
        
    foreach ($rows as $i) {
        if ($i['email'] == $_POST['email']){
            $used = true;
        }
    } 

    

    if (!$used) {
        $stmt = $pdo->prepare("insert into users (email, pass) values (:em , :ps)");
        $stmt->execute(array(":em" => $_POST['email'], ":ps" => $_POST['pass']));
        $stmt = $pdo->prepare("select user_id from users where email = :em");
        $stmt->execute(array(":em" => $_POST['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare("insert into profiles (profile_id, bio, username, cant_tallas) values (:pi , :bio, :un, :ct)");
        $stmt->execute(array(":pi" => $row['user_id'], ":bio" => $_POST['sum'], ":un" => $_POST['uname'], ":ct" => 0));
        $_SESSION["user"]['name'] = $_POST['uname'];
        $_SESSION["user"]['email'] = $_POST['email'];
        $_SESSION["user"]['id'] = $row['user_id'];
        echo 'Ok';
    }