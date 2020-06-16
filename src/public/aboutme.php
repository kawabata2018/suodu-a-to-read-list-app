<?php

// import class
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

// enable utf-8
mb_regex_encoding("UTF-8");

// get session values
session_start();
// if session has expired, move to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /408');
    exit;
}
$userId = $_SESSION['user_id'];

// get account information
// @user: User object
$dao = new UserDAO();

$searchId = $_GET['id'];
$res = $dao->userPublicOrNot($searchId);
if (! $res) {
    $searchId = $userId;
}
$user = $dao->getUser($searchId);

?>

<?php include('templates/header-lib.php'); ?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3">
        <?= $user->getUserName(); ?>さんの書庫
        <?php if ($user->getIsProtected() == 1) { ?>
            🔑
        <?php } ?>
    </p>
    <p class="text-center mt-2"> <?= $user->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>

    <p class="text-center mt-0">joined at <?= $user->getCreatedAt(); ?> </p>

    <?php if ($searchId == $userId) { ?>
        <div class="text-right">
            <button type="submit" class="btn btn-icon-green" onClick="location.href='/public/edit-aboutme'">編集</button>
        </div>
    <?php } ?>
</div>

<?php include('templates/footer-lib.php'); ?>
