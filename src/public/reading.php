<?php

// import class
require_once 'templates/escape-func.php';

/** 
 * book color
 * 0: blue
 * 1: red
 * 2: yellow
 * 3: green
 */
$bookImgPath = array(
    '0' => '/public/img/book_00.png',
    '1' => '/public/img/book_01.png',
    '2' => '/public/img/book_02.png',
    '3' => '/public/img/book_03.png',
);

// get session values
session_start();
$userId = $_SESSION['user_id'];

// unset session values
unset($_SESSION['book_name']);
unset($_SESSION['total_page']);
unset($_SESSION['target_date']);
unset($_SESSION['color_tag']);

// enable utf-8
mb_regex_encoding("UTF-8");

// when submitted on modal window
if (isset($_POST['submitAdd'])) {
    $bookName = $_POST['bookName'];
    $totalPage = $_POST['totalPage'];
    $targetDate = $_POST['targetDate'];
    $colorTag = $_POST['colorTag'];

    // check totalPage
    if (! empty($targetDate)) {
        if (! preg_match('/^[0-9].{0,6}$/', $totalPage)) {
            header('Location: /500#invalidform');
            exit;
        }
    }

    // check targetDate
    if (! empty($targetDate)) {
        if (! strptime($targetDate, '%Y-%m-%d')) {
            header('Location: /500#invalidform2');
            exit;
        }
    }

    // check colorTag
    if (! preg_match('/^[0-3]$/', $colorTag)) {
        header('Location: /500#invalidform3');
        exit;
    }

    $_SESSION['book_name'] = hescape($bookName);
    $_SESSION['total_page'] = hescape($totalPage);
    $_SESSION['target_date'] = hescape($targetDate);
    $_SESSION['color_tag'] = hescape($colorTag);
    // echo 'REDIRECT';
    header('Location: /controller/Addbook-controller');
    exit;
}

?>

<?php include('templates/header-lib.php'); ?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> 読みたい </p>

    <button type="button" class="btn btn-info btn-round-2 rounded-circle p-0 m-2" data-toggle="modal" data-target="#add-modal">＋</button>

    <div class="border-reading-frame bg-white my-2">

        <?php for ($i = 0; $i < 10; $i++) { ?>
        <div class="border-reading-line">
            <div class="container p-2 p-md-3">
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-1 d-flex align-items-center pr-0">
                        <img src=" <?php echo $bookImgPath['1'] ?> " style="width:100%; ">
                    </div>
                    <div class="col-9 col-sm-10 col-md-9">
                        <div class="m-2">
                            <span class="h5 font-yumin">完訳水滸伝（岩波文庫）</span>
                        </div>
                        <div class="mx-3 mt-3 mb-1">
                            <div class="progress">
                                <div class="progress-bar bg-sucess" role="progressbar" style="width: 60%">60%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-9 col-xs-10 col-md-12 d-flex align-items-center pl-4 pl-md-2 py-md-1">
                                <span>あと10日</span>
                            </div>
                            <div class="col-3 col-xs-2 col-md-12 p-2">
                                <button class="btn-sm btn-info">詳細</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>


    <div id="add-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!-- <div class="modal-backdrop fade in"></div> -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="app-add" class="container p-3">
                    <h3 class="font-yumin pb-3 text-center">本を追加</h3>
                    <form method="POST">
                        <div class="form-group pb-1">
                            <label>書名（50字以内）</label>
                            <textarea type="text" name="bookName" v-model="bookName" class="form-control border-login" rows="2"></textarea>
                            <span class="text-danger">{{ error.bookName }}</span>
                        </div>
                        <div class="form-row pb-1">
                            <div class="form-group col-6">
                                <label>ページ数</label>
                                <input type="number" name="totalPage" v-model="totalPage" class="form-control">
                                <span class="text-danger">{{ error.totalPage }}</span>
                            </div>
                            <div class="form-group col-6">
                                <label>目標日付</label>
                                <input type="text" name="targetDate" class="form-control" id="date">
                            </div>
                        </div>
                        <div class="form-group pb-1">
                            <label>タグ</label>
                            <div class="custom-radio btn-group btn-group-toggle d-flex">
                                <input type="radio" name="colorTag" id="option1" value="0" autocomplete="off" checked>
                                    <label for="option1" class="btn btn-primary w-100 active">青</label>
                                <input type="radio" name="colorTag" id="option2" value="1" autocomplete="off">
                                    <label for="option2" class="btn btn-danger w-100">赤</label>
                                <input type="radio" name="colorTag" id="option3" value="2" autocomplete="off">
                                    <label for="option3" class="btn btn-warning w-100">黄</label>
                                <input type="radio" name="colorTag" id="option4" value="3" autocomplete="off">
                                    <label for="option4" class="btn btn-success w-100">緑</label>
                            </div>
                        </div>
                        <button type="submit" name="submitAdd" v-bind:disabled="!isValid" class="btn btn-primary">追加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer-lib.php'); ?>
