<?php

// import class
require_once 'templates/escape-func.php';
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];

// enable utf-8
mb_regex_encoding("UTF-8");

?>

<?php include('templates/header-lib.php'); ?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> 読んだ </p>

    <div class="border-reading-frame bg-white my-3">

        <?php
        for ($i = 0; $i < 3; $i++) {
        ?>
        <div class="border-reading-line">
            <div class="container p-2 p-md-3">
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-1 d-flex align-items-center pr-0">
                        <img src="/public/img/book_10.png" style="width:100%; ">
                    </div>
                    <div class="col-9 col-sm-10 col-md-9 col-lg-10">
                        <div class="m-2">
                            <span class="h5 font-yumin">完訳水滸伝（岩波文庫）</span>
                        </div>
                        <!-- <div class="mx-3 mt-3 mb-1">
                            <div class="progress">
                                <div class="progress-bar bg-sucess" role="progressbar" style="width: 66%">66%</div>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-md-2 col-lg-1">
                        <div class="row">
                            <div class="col-9 col-xs-10 col-md-12 d-flex align-items-center pl-4 pl-md-2 py-md-1">
                                <!-- <span>あと10日</span> -->
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

</div>

<?php include('templates/footer-lib.php'); ?>
