<?php

// import class
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
$userInfo = $_SESSION['user_info'];
$relationInfo = $_SESSION['relation_info'];

?>

<?php
if ($userId == $_GET['id']) {
    include('templates/header-lib.php'); 
} else {
    include('templates/header-lib-alt.php'); 
}
?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3">
        <?= $userInfo->getUserName(); ?>さんの書庫
        <?php if ($userInfo->getIsProtected() == 1) { ?>
            🔑
        <?php } ?>
    </p>

    <div class="text-center">
    <?php if ($_GET['id'] != $userId) { ?>
        <?php if (in_array('Followed', $relationInfo)) { ?>
            <p class="text-muted">フォローされてるよ</p>
        <?php } ?>
        <?php if (in_array('Pending', $relationInfo)) { ?>
            <p class="text-muted">フォロー申請されてるよ <a href="/controller/Relation-controller?action=accept&id=<?= $_GET['id'] ?>">承認</a></p>
        <?php } ?>
    <?php } else { ?>
        <p class="text-muted">じぶん</p>
    <?php } ?>
    </div>

    <?php if (in_array('Following', $relationInfo)) { ?>
        <div class="text-center">
            <button class="btn btn-outline-icon-navy mx-4 mb-3" onClick="location.href='/controller/Reading-controller?sort=0&id=<?= $_GET['id'] ?>'">
                読みたい
            </button>
            <button class="btn btn-outline-icon-navy mx-4 mb-3" onClick="location.href='/controller/Library-controller?sort=0&id=<?= $_GET['id'] ?>'">
                読んだ
            </button>
        </div>
    <?php } ?>

    <p class="text-center mt-3"> <?= $userInfo->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>
    <?php /* <p class="text-center mt-0">joined at <?= $userInfo->getCreatedAt(); ?> </p> */ ?>

    <?php if ($_GET['id'] == $userId) { ?>
        <div class="text-right">
            <button type="submit" class="btn btn-icon-green" onClick="location.href='/public/edit-aboutme'">編集</button>
        </div>
    <?php } else { ?>
        <div class="text-right">
            <?php if (in_array('Following', $relationInfo)) { ?>
                <button type="button" id="followingBtn" class="btn-sm btn-icon-green">フォロー中</button>
            <?php } ?>
            <?php if (in_array('Requesting', $relationInfo)) { ?>
                <button type="button" id="requestingBtn" class="btn-sm btn-icon-green">フォロー申請中</button>
            <?php } ?>
            <?php if (in_array('NotFollowing', $relationInfo)) { ?>
                <button type="submit" class="btn-sm btn-outline-icon-green" onClick="location.href='/controller/Relation-controller?action=follow&id=<?= $_GET['id'] ?>'">フォローする</button>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php include('templates/footer-lib.php'); ?>
