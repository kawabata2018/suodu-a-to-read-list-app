<?php

require_once '../dao/UserDAO.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];
$name = $_SESSION['name'];
$profile = $_SESSION['profile'];
$publishOrNot = $_SESSION['publish_or_not'];

// unset session values
unset($_SESSION['name']);
unset($_SESSION['profile']);
unset($_SESSION['publish_or_not']);

// update account information
$dao = new UserDAO();
/**
 * try to update profile and is_protected
 * @isProtected:
 *   false: public
 *   true: protected
 */
$isProtected = ($publishOrNot == 'on')? false: true;
$res = $dao->updateUserWelcome($userId, $name, $profile, $isProtected);


if ($res) {
    // echo '<br>アカウントが更新されました。';
    header('Location: /controller/Aboutme-controller?id='.$userId);
    exit;

} else {
    // echo '<br>アカウント更新に失敗しました。';
    header('Location: /500');
    exit;
}

?>