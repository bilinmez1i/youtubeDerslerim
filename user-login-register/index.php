<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login And Register </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

require_once "config.php";

if(isset($_COOKIE['login'])){
        $user_ask = $db->prepare('SELECT * FROM users WHERE user_key=:user_key');
        $user_ask->execute(array('user_key' => $_COOKIE['login']));
        $user_check = $user_ask->fetch(PDO::FETCH_ASSOC); 
    ?>
        <center>Sisteme <b><?= $user_check['user_name'] ?></b> ile giriş yaptınız...</center>
        <br>
        <center>
            <form action="login.php" method="post">
                <button name="logoutBtn"> Çıkış Yap </button>
            </form>
        </center>  
    <?php } else {
        Header('location:login.php');
    } ?>
</body>
</html>