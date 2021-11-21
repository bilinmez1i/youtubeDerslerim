<?php
require_once "config.php";

if(isset($_POST['loginBtn'])){
        $user_key = md5($_POST['user_name'] . $_POST['user_password']);
        $user_ask = $db->prepare('SELECT * FROM users WHERE user_key=:user_key');
        $user_ask->execute(array(
            'user_key' => $user_key
        ));
        if($user_ask->rowCount()>0){
            setcookie('login', $user_key, time() + 3200 * 2400, '/');
            $user_check = $user_ask->fetch(PDO::FETCH_ASSOC);
            Header('Location:index.php');
        } else {
            $error = "BÖYLE BİR KULLANICI YOK. KAYIT OL";
        }
    }
    if(isset($_POST['registerBtn'])){
        $newUser = $db->prepare('INSERT INTO users SET 
        user_name=:user_name,
        user_password=:user_password,
        user_key=:user_key');
        $status = $newUser->execute(array(
            "user_name" => $_POST['user_name'],
            "user_password" => $_POST['user_password'],
            "user_key" => md5($_POST['user_name'] . $_POST['user_password'])
        ));
        if($status){
            setcookie('login', md5($_POST['user_name'] . $_POST['user_password']), time() + 3200 * 2400, '/');
            Header('Location:index.php');
        } else {
            $error = "Kullanıcı Kaydedilemedi";
        }

    }
    if(isset($_POST['logoutBtn'])){
        unset($_COOKIE['login']); 
        setcookie('login', null, -1, '/');
        Header('Location:index.php');
    }
?>
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
    <?php if(isset($_COOKIE['login'])){
        Header('Location:index.php');
    } else { ?>
        <div class="loginAndRegister">
            <section class="login">
                <form action="" 
                method="POST" 
                autocomplete="off">
                    <div class="container">
                        <h1> Login </h1>
                        <?php if (isset($error)){echo "<span class='error'>" . $error . "</span>"; }?>
                        <input type="text" name="user_name" placeholder="Username">
                        <input type="password" name="user_password" placeholder="Password">
                        <button name="loginBtn"> Login  </button>
                    </div>
                </form>
            </section>

            <section class="login">
                <form action="" 
                method="POST" 
                autocomplete="off">
                    <div class="container">
                        <h1> Register </h1>
                        <?php if (isset($error)){echo "<span class='error'>" . $error . "</span>"; }?>
                        <input type="text" name="user_name" placeholder="Username">
                        <input type="password" name="user_password" placeholder="Password">
                        <button name="registerBtn"> Register  </button>
                    </div>
                </form>
            </section>
        </div>
    <?php } ?>
</body>
</html>