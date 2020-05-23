<?php

require_once '../dao/UserDAO.php';

// get session values
session_start();
$name = $_SESSION['name'];
$profile = $_SESSION['profile'];
$publishOrNot = $_SESSION['publishOrNot'];

// unset session values
unset($_SESSION['name']);
unset($_SESSION['profile']);
unset($_SESSION['publishOrNot']);

// get user id
$id = $_GET['id'];

// update account information
$dao = new UserDAO();
$dao->connect();
/**
 * try to update profile and is_protected
 * @isProtected:
 *   false: public
 *   true: protected
 */
$isProtected = ($publishOrNot == 'on')? false: true;
$res = $dao->updateUserWelcome($id, $name, $profile, $isProtected);
$dao->close();

if ($res) {
    // echo '<br>アカウントが更新されました。';
    header('Location: /public/library.php?id='.$id);
    exit;

} else {
    // echo '<br>アカウント更新に失敗しました。';
    header('Location: /500');
    exit;
}

?>