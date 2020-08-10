<?php

// import class
require_once 'templates/escape-func.php';
require_once '../entity/User.php';
require_once '../dao/UserDao.php';
require_once '../dao/RelationDao.php';

$errors = array('searchId'=>'');

// get session values
session_start();
// if session has expired, move to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /408');
    exit;
}
$userId = $_SESSION['user_id'];
$searchId = $_SESSION['search_id'];
$searchResult = $_SESSION['search_result'];
$relationInfo = $_SESSION['relation_info'];

// unset session values
unset($_SESSION['search_id']);
unset($_SESSION['search_result']);

$userDao = new userDao();
$relationDao = new RelationDao();
$followings = $relationDao->getFollowings($userId);
$followers = $relationDao->getFollowers($userId);
$pendings = $relationDao->getPendings($userId);


// enable utf-8
mb_regex_encoding("UTF-8");

if (isset($_POST['submit'])) {
    // check searchId
    $id = trim($_POST['id'], ' ');
    if (!preg_match('/^[a-zA-Z0-9_]{4,12}$/', $id)) {
        $errors['searchId'] = '英数4-12文字で入力してね';
    }

    if (!array_filter($errors)) {
        $_SESSION['search_id'] = hescape($id);
        // echo 'REDIRECT';
        header('Location: /controller/Relation-controller?action=search&id='.hescape($id));
        exit;
    }
}

?>

<?php include('templates/header-lib.php'); ?>

<div class="container my-3">
    <form method="POST" class="mb-4">
        <p class="text-center font-yumin h4">書友をさがす</p>
        <div class="text-center">
            <span class="text-danger"> <?= $errors['searchId']; ?> </span>
            <div>
                <input type="text" name="id" class="border-login m-2 p-2" placeholder="読者IDを入力"></input>
                <button type="submit" name="submit" class="btn btn-icon-navy">検索</button>
            </div>
        </div>
        <div>
            <?php if ($searchResult == 'NotFound') { ?>
                <p class="text-center text-danger">書友 <?= $searchId ?> は見つからないよ</p>
            <?php } ?>
            <?php if ($searchResult == 'Found') { ?>
                <p class="text-center">書友<a href="/controller/Aboutme-controller?id=<?= $searchId ?>"> <?= $searchId ?> </a>が見つかったよ！</p>
            <?php } ?>
        </div>
    </form>

    <p class="text-center font-yumin">書友をフォローすると、その書庫が見られるようになるよ</p>
    <div class="rounded border-reading-frame bg-white p-3 my-3">
        <p class="font-yumin h5">フォロー中</p>
        <?php if (is_null($followings) or (count($followings) == 0)) { ?>
            <p class="text-center mx-2 mt-3">誰もフォローしていないよ。書友をさがそう！</p>
        <?php } else { ?>
            <div class="mx-2 mt-3">
            <?php foreach ($followings as $id) { ?>
                <button class="btn btn-light btn-link border m-1 p-2">
                    <a href="/controller/Aboutme-controller?id=<?= $id ?>"><?= $userDao->getName($id) ?>（<?= $id ?>）</a>
                </button>
            <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="rounded border-reading-frame bg-white p-3 my-3">
        <p class="font-yumin h5">フォロワー</p>
        <?php if (is_null($followers) or (count($followers) == 0)) { ?>
            <p class="text-center mx-2 mt-3">誰にもフォローされていないよ。書友にじぶんを紹介しよう！</p>
        <?php } else { ?>
            <div class="mx-2 mt-3">
            <?php foreach ($followers as $id) { ?>
                <button class="btn btn-light btn-link border m-1 p-2">
                    <a href="/controller/Aboutme-controller?id=<?= $id ?>"><?= $userDao->getName($id) ?>（<?= $id ?>）</a>
                </button>
            <?php } ?>
            </div>
        <?php } ?>
    </div>

    <?php if (count($pendings) != 0) { ?>
    <div class="rounded border-reading-frame bg-white p-3 my-3">
        <p class="font-yumin h5">承認待ち</p>
            <div class="mx-2 mt-3">
            <?php foreach ($pendings as $id) { ?>
                <button class="btn btn-light btn-link border m-1 p-2">
                    <a href="/controller/Aboutme-controller?id=<?= $id ?>"><?= $userDao->getName($id) ?>（<?= $id ?>）</a>
                </button>
            <?php } ?>
            </div>
    </div>
    <?php } ?>

</div>

<?php include('templates/footer-lib.php'); ?>
