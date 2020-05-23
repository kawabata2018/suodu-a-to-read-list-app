<?php

require_once '../dao/UserDAO.php';

// get session values
session_start();
$id = $_SESSION['id'];
$password = $_SESSION['password'];

// start login process
$dao = new UserDAO();
$dao->connect();
/**
 * if the entered id does not match any users,
 * alert that the user does not exist in the db.
 */
$res = $dao->userExistsOrNot($id);

if (! $res) {
    $_SESSION['invalidIdError'] = 'その読者IDはまだ登録されてないよ';
    header('Location: /public/login.php');
    exit;

} else {
    $hashedPassword = $dao->getPassword($id);
    $dao->close();
    if (password_verify($password, $hashedPassword)) {
        // echo 'Signed in successfully!!';
        header('Location: /public/library.php?id='.$id);
        exit;

    } else {
        $_SESSION['invalidPasswordError'] = 'あいことばが正しくないよ';
        header('Location: /public/login.php');
        exit;
    }

}

?>