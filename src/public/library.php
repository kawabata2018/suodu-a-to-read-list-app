<?php

// import class
require_once 'templates/escape-func.php';
require_once '../entity/ToRead.php';

// definite sort types
$sortTypes = array(
    '0'  => '読了順',
    '1'  => '更新順',
    '2'  => '書名順',
    '80' => '青のみ',
    '81' => '赤のみ',
    '82' => '黄のみ',
    '83' => '緑のみ',
);
// definite color tag
$colorTypes = array(
    '0',    // blue
    '1',    // red
    '2',    // yellow
    '3',    // green
);
$bookImgPath = array(
    '0' => '/public/img/book_10.png',
    '1' => '/public/img/book_11.png',
    '2' => '/public/img/book_12.png',
    '3' => '/public/img/book_13.png',
);

// get session values
session_start();
// if session has expired, move to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /408');
    exit;
}
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$toreadSearchResult = $_SESSION['toread_search_result'];

// enable utf-8
mb_regex_encoding("UTF-8");

?>

<?php include('templates/header-lib.php'); ?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> <?= $userName ?>さんの読んだ </p>

    <nav class="navbar">
        <div></div>
        <div class="dropdown navbar-right">
            <button class="btn btn-outline-icon-green dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                並び替え
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=0&id='.$_GET['id'] ?>"><?= $sortTypes['0'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=1&id='.$_GET['id'] ?>"><?= $sortTypes['1'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=2&id='.$_GET['id'] ?>"><?= $sortTypes['2'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=80&id='.$_GET['id'] ?>"><?= $sortTypes['80'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=81&id='.$_GET['id'] ?>"><?= $sortTypes['81'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=82&id='.$_GET['id'] ?>"><?= $sortTypes['82'] ?></a>
                <a class="dropdown-item" href="<?= '/controller/Library-controller?sort=83&id='.$_GET['id'] ?>"><?= $sortTypes['83'] ?></a>
            </div>
        </div>
    </nav>

    <?php if (is_null($toreadSearchResult) or (count($toreadSearchResult) == 0)) { ?>
    <div class="text-center my-5">
        <span class="display-1 font-yumin text-muted">空</span>
    </div>
    <?php } else { ?>
    <div class="border-reading-frame box-shadow-2 bg-white my-2">

        <?php foreach ($toreadSearchResult as $index=>$toread) { ?>
        <div class="border-reading-line">
            <div class="container p-2 p-md-3">
                <div class="row">
                    <div class="col-3 col-sm-2 col-lg-1 pr-0 d-flex align-items-center cursor-pointer" data-toggle="modal" data-target="#detailModal" data-index="<?= $index; ?>">
                        <img src="<?= $bookImgPath[$toread->getColorTag()] ?>" style="width:100%; ">
                    </div>
                    <div class="col-9 col-sm-10 col-lg-11">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="mx-2">
                                    <span class="h5 font-yumin inline-block"><?= $toread->getBookName() ?></span>
                                    <span class="font-yumin inline-block"><?= $toread->getAuthorName() ?></span>
                                </div>
                                <div class="m-2">
                                    <span class=""><?= nl2br($toread->getMemo()) ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 pl-0">
                                <div class="mx-2 text-right">
                                    <span class="d-inline-block"><?= date('n月d日', strtotime($toread->getCompletedOn())); ?></span>
                                    <span class="d-inline-block">読了</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
    <div class="font-yumin text-right pr-2"><?= $sortTypes[$_GET['sort']] ?></div>
    <?php } ?>

    <div id="detailModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-book">
                <div id="appDetail" class="container p-3"></div>
            </div>
        </div>
    </div>

</div>

<?php include('templates/footer-lib.php'); ?>
