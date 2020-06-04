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
    <p class="text-center font-yumin h4 mt-3"> 読みたい </p>

    <button type="button" class="btn btn-info btn-round-2 rounded-circle p-0 m-2" data-toggle="modal" data-target="#add-modal">＋</button>

    <div class="border-reading-frame bg-white my-2">

        <?php
        for ($i = 0; $i < 10; $i++) {
        ?>
        <div class="border-reading-line">
            <div class="container p-2 p-md-3">
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-1 d-flex align-items-center pr-0">
                        <img src="/public/img/book_00.png" style="width:100%; ">
                    </div>
                    <div class="col-9 col-sm-10 col-md-9">
                        <div class="m-2">
                            <span class="h5 font-yumin">完訳水滸伝（岩波文庫）</span>
                        </div>
                        <div class="mx-3 mt-3 mb-1">
                            <div class="progress">
                                <div class="progress-bar bg-sucess" role="progressbar" style="width: 66%">66%</div>
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
        <?php
        }
        ?>
        
    </div>


    <div id="add-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!-- <div class="modal-backdrop fade in"></div> -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container p-3">
                    <h3 class="font-yumin pb-3 text-center">本を簡単追加</h3>
                    <form method="POST">
                        <div class="form-group pb-1">
                            <label>書名（50字以内）</label>
                            <textarea type="text" name="bookname" class="form-control border-login" rows="2"></textarea>
                            <span class="text-danger"> <?php echo $errors['bookname']; ?> </span>
                        </div>
                        <div class="form-row pb-1">
                            <div class="form-group col-6">
                                <label>ページ数</label>
                                <input type="text" name="totalpage" class="form-control">
                                <span class="text-danger"> <?php echo $errors['totalpage']; ?> </span>
                            </div>
                            <div class="form-group col-6">
                                <label>目標日付</label>
                                <input type="text" class="form-control" id="date_sample">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">追加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer-lib.php'); ?>
