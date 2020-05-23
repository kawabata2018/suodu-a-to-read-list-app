<?php

require_once '../dao/UserDAO.php';

session_start();

$id = $_SESSION['id'];
$password = $_SESSION['password'];

if (!preg_match('/^[a-zA-Z0-9_]{4,12}$/', $id) or !preg_match('/^[a-zA-Z0-9_]{4,12}$/', $password)) {
    header('Location: /404');
} else {
    $dao = new UserDAO();
    $dao->connect();
    /**
     * if the entered id already exists,
     * alert that they should sign up using other ids.
     */
    $res1 = $dao->userExistsOrNot($id);

    if ($res1) {
        $_SESSION['userExistsError'] = 'その読者IDはすでに存在するよ';
        $dao->close();
        header('Location: /public/signup.php');
        exit;

    } else {
        $res2 = $dao->createUser($id, $password);
        $dao->close();
        if ($res2) {
            header('Location: /public/welcome.php?id=' . $id);
            exit;
        } else {
            // echo '<br>アカウント作成に失敗しました。';
            header('Location: /500');
            exit;
        }

    }

}

?>