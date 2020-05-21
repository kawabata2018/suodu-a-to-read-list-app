<?php

require '../dao/UserDAO.php';

session_start();

$id = $_SESSION['id'];
$password = $_SESSION['password'];

if (!preg_match('/^[a-zA-Z0-9]{6,12}$/', $id) or !preg_match('/^[a-zA-Z0-9]{6,12}$/', $password)) {
    header('Location: /404');
} else {
    $dao = new UserDAO();
    $dao->connect();
    $res1 = $dao->existsUserOrNot($id);

    if ($res1) {
        $_SESSION['existsUserError'] = 'その読者IDはすでに存在するよ';
        header('Location: /public/signup.php');

    } else {
        $res2 = $dao->createUser($id, $password);
        if ($res2) {
            header('Location: /public/welcome.php');
        }

    }


}


?>