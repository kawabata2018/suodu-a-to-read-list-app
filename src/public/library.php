<?php include('templates/header-lib.php'); ?>

<?php

// import class
require_once 'templates/escape-func.php';
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$dao->connect();
$user = $dao->getUser($userId);
$dao->close();

?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> 読んだ </p>

</div>

<?php include('templates/footer-lib.php'); ?>
