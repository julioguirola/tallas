<?php 
    require_once 'pdo.php';
    session_start();

    $stmt = $pdo->prepare('SELECT user_id, email, pass FROM users WHERE email = :em');
    $stmt->execute(array( ':em' => $_POST['email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('SELECT username FROM profiles WHERE profile_id = :id');
    $stmt->execute(array( ':id' => $row['user_id']));
    $em = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row['pass'] == $_POST['pass']){
        $_SESSION["user"]['name'] = $em['username'];
        $_SESSION["user"]['email'] = $_POST['email'];
        $_SESSION["user"]['id'] = $row['user_id'];
        echo "Ok";
    } else {
        echo "<p style='color: red;'>Usuario o contraseña incorrecto</p>";
        
    }
    