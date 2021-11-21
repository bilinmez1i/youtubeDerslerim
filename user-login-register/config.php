<?php 

try {
    $db = new PDO("mysql:host=localhost;dbname=ders;charset=utf8", "root", "");
} catch (PDOException $e) {
    die($e);
}

?>