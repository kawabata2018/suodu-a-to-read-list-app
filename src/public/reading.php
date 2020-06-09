<?php

// import class
require_once 'templates/escape-func.php';
require_once '../entity/ToRead.php';

// definite sort types
$sortTypes = array(
    '0'  => '〆切順',
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
    '0' => '/public/img/book_00.png',
    '1' => '/public/img/book_01.png',
    '2' => '/public/img/book_02.png',
    '3' => '/public/img/book_03.png',
);

// get session values
session_start();
$userId = $_SESSION['user_id'];
$toreadSearchResult = $_SESSION['toread_search_result'];

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
            header('Location: /500#invalidform');
            exit;
        }
    }

    // check colorTag
    if (! in_array($colorTag, $colorTypes)) {
        header('Location: /500#invalidform');
        exit;
    }

    $_SESSION['book_name'] = hescape($bookName);
    $_SESSION['total_page'] = hescape($totalPage);
    $_SESSION['target_date'] = hescape($targetDate);
    $_SESSION['color_tag'] = hescape($colorTag);
    // echo 'REDIRECT';
    header('Location: /controller/AddBook-controller');
    exit;
}

?>

<?php include('templates/header-lib.php'); ?>

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> 読みたい </p>

    <nav class="navbar">
        <button type="button" class="btn btn-info btn-round-2 p-0 m-2 rounded-circle" data-toggle="modal" data-target="#addModal">＋</button>
        <div class="dropdown navbar-right">
            <button class="btn btn-outline-info dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                並び替え
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=0&id='.$_GET['id'] ?> "><?php echo $sortTypes['0'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=1&id='.$_GET['id'] ?> "><?php echo $sortTypes['1'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=2&id='.$_GET['id'] ?> "><?php echo $sortTypes['2'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=80&id='.$_GET['id'] ?> "><?php echo $sortTypes['80'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=81&id='.$_GET['id'] ?> "><?php echo $sortTypes['81'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=82&id='.$_GET['id'] ?> "><?php echo $sortTypes['82'] ?></a>
                <a class="dropdown-item" href=" <?php echo '/controller/Reading-controller?sort=83&id='.$_GET['id'] ?> "><?php echo $sortTypes['83'] ?></a>
            </div>
        </div>
    </nav>

    <div class="border-reading-frame bg-white my-2">

        <?php foreach ($toreadSearchResult as $reading) { ?>
        <div class="border-reading-line">
            <div class="container p-2 p-md-3">
                <div class="row">
                    <div class="col-3 col-sm-2 col-lg-1 pr-0 d-flex align-items-center">
                        <img src=" <?php echo $bookImgPath[$reading->getColorTag()] ?> " style="width:100%; ">
                    </div>
                    <div class="col-9 col-sm-10 col-lg-11">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="mx-2">
                                    <span class="h5 font-yumin"><?php echo $reading->getBookName() ?></span>
                                </div>
                                <div class="mx-2 my-3 cursor-pointer" data-toggle="modal" data-target="#progressModal"
                                        data-toreadid=" <?php echo $reading->getToreadId(); ?> "
                                        data-currentpage=" <?php echo $reading->getCurrentPage(); ?> "
                                        data-totalpage=" <?php echo $reading->getTotalPage(); ?> ">
                                    <div class="progress">
                                        <div class="progress-bar bg-sucess" role="progressbar" style="width: <?php echo $reading->getProgressPct() ?>%"><?php echo $reading->getProgressPct() ?>%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 pl-0">
                                <div class="mx-2 text-right">
                                    <span class="d-inline-block"><?php echo $reading->getIsOverdue()==true ? '超過': 'あと'; ?></span>
                                    <span class="d-inline-block"><?php echo $reading->getDaysDiff(); ?>日</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
    <div class="font-yumin text-right pr-2"><?php echo $sortTypes[$_GET['sort']] ?></div>


    <div id="addModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="appAdd" class="container p-3">
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

    <div id="progressModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myProgressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="appProgress" class="container p-3">
                    <div class="h5 text-center">進捗度</div>
                    <form method="POST" action="/controller/UpdateProgress-controller">
                        <input type="hidden" id="toreadId" name="toreadId">
                        <div class="form-group">
                            <label for="range">Progress:</label>
                            <label id="rangeValue"></label>
                            <label id="rangeMax"></label>
                            <input type="range" id="range" name="rangeValue" class="form-control-range"
                                    min="0" max="" value="" step="1">
                        </div>
                        <button type="submit" class="btn btn-info">更新</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('templates/footer-lib.php'); ?>
