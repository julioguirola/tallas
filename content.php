<?php
    session_start();
    require_once 'pdo.php';

    $stmt = $pdo->query('select username, bio, profile_id from profiles order by username');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->query('select tallas.talla, tallas.talla_id , tallas.date_, profiles.username from tallas inner join profiles on tallas.id = profiles.profile_id');
    $tallas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = array('user' => "<h2 style='color: green;'>Wellcome ".htmlentities($_SESSION['user']['name'])."</h2><a href='logout.php'>Desconectarme</a><p>Para conocer más acerca de este sitio pulse <a href='about.html' onclick='who()'>aquí</a></p>", 'users' => '', 'tallas' => '');

    
    // [0] => Array ( [talla] => adasd [date_] => 06/10/2023 11:59:34 [username] => Julio )
    for ($i = count($tallas)-1; $i > -1; $i-- ){

        $stmt = $pdo->prepare("select like_, dislike_ from who where tallaid = :ti");
        $stmt->execute(array(':ti' => $tallas[$i]['talla_id']));
        $total_like = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $likes = 0;
        $dislikes = 0;

        for ($z=0; $z < count($total_like); $z++) { 
            if ($total_like[$z]['like_'] % 2 != 0) $likes++;
            if ($total_like[$z]['dislike_'] % 2 != 0) $dislikes++;
        }

        $data['tallas'] = $data['tallas']."<div class='talla'>";
        $data['tallas'] = $data['tallas']."<p style='color: rgb(56, 56, 247);'>".htmlentities($tallas[$i]['username'])." a las ".$tallas[$i]['date_']." dijo:</p>";
        $data['tallas'] = $data['tallas']."<p>".htmlentities($tallas[$i]['talla'])."</p>";
        $data['tallas'] = $data['tallas']."<input type='button' value='Clase talla 👍: ".$likes."' onclick='darlike(".$tallas[$i]['talla_id'].")'><input type='button' value='Talla turbia 👎: ".$dislikes."' onclick='dardislike(".$tallas[$i]['talla_id'].")'>";
        
        if ($_SESSION['user']['name'] == $tallas[$i]['username'] || $_SESSION['user']['id'] == 6) {
            //enviar post con js, el parametro de onclick es tallas_id
            $data['tallas'] = $data['tallas']."<a href='delete.php?id=".$tallas[$i]['talla_id']."&uid=".$_SESSION['user']['id']."'>Borrar Talla</a>";
        }
        $data['tallas'] = $data['tallas']."</div>";                
    }


   
    foreach ($users as $user) {
        $data['users'] = $data['users']."<span style='color: rgb(56, 56, 247);'>".htmlentities($user['username'])."</span>:  ".htmlentities($user['bio'])."<br><br>";
    }


    echo(json_encode($data));
    
        
