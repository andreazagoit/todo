<?php

$connection = mysqli_connect("79.45.179.9", "admin", 'password', "S2I1");

$errorMsg = '';

if (isset($_POST["rusername"]) && isset($_POST['rpassword'])) {
    $username = strtolower(stripslashes($_POST['rusername'])) ?? '';
    $password = md5(stripslashes($_POST['rpassword'])) ?? '';
    if ((strlen($username) > 3) && (strlen($password) > 3)) {
        $login = mysqli_query($connection, "SELECT * from todologin WHERE username='$username';");
        $login = mysqli_fetch_all($login, MYSQLI_ASSOC);
        if (count($login) == 0) {
            mysqli_query($connection, "INSERT INTO `todologin` (`id`, `username`, `password`) VALUES (NULL, '$username', '$password');");
            mysqli_query($connection, "CREATE TABLE `S2I1`.`todo_$username` ( `id` INT NOT NULL AUTO_INCREMENT , `task` VARCHAR(200) NOT NULL , `completed` BOOLEAN NOT NULL DEFAULT FALSE , `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
            setcookie("username", $username, time() + (86400 * 30), "/");
            header("Refresh:0, url='/todo/'");
        } else {
            $errorMsg = 'Account giá esistente';
        }
    } else {
        $errorMsg = 'Credenziali troppo corte';
    }
}
if (!isset($_COOKIE["username"])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = strtolower(stripslashes($_POST['username'])) ?? '';
        $password = md5(stripslashes($_POST['password'])) ?? '';
        $login = mysqli_query($connection, "SELECT * from todologin WHERE username='$username' AND password='$password';");
        $login = mysqli_fetch_all($login, MYSQLI_ASSOC);
        if (count($login) > 0) {
            setcookie("username", $username, time() + (86400 * 30), "/");
            header("Refresh:0, url='/todo/'");
        } else {
            $errorMsg = 'Credenziali errate';
        }
    }
} else {
    $username = $_COOKIE['username'];
}

if (isset($_POST['todo'])) {
    $todo = $_POST['todo'];
    mysqli_query($connection, "INSERT INTO `todo_$username` (`id`, `task`, `completed`, `time`) VALUES (NULL, '$todo', '0', current_timestamp())");
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "logout") {
        setcookie("username", null, -1, "/");
        header("Refresh:0, url='/todo/'");
    }
    if ($_GET['action'] == "delete") {
        $id = $_GET["id"];
        mysqli_query($connection, "DELETE FROM `todo_$username` WHERE id=$id;");
    }
    if ($_GET['action'] == "complete") {
        $id = $_GET["id"];
        mysqli_query($connection, "UPDATE `todo_$username` SET completed=1 WHERE id=$id;");
    }
    if ($_GET['action'] == "incomplete") {
        $id = $_GET["id"];
        mysqli_query($connection, "UPDATE `todo_$username` SET completed=0 WHERE id=$id;");
    }
}

$todos = mysqli_query($connection, "SELECT * FROM `todo_$username`");
$todos = mysqli_fetch_all($todos, MYSQLI_ASSOC);

if (!$connection) {
    $errorMsg = 'Errore di connessione al Database';
}
