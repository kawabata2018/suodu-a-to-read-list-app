<?php

// import class
require_once 'templates/escape-func.php';
require_once '../dao/ToReadDAO.php';
require_once '../entity/ToRead.php';

// definite color tag
$colorTypes = array(
    '0',    // blue
    '1',    // red
    '2',    // yellow
    '3',    // green
);

// get query parameters
$toreadId = $_GET['toreadId'];
$from = $_GET['from'];

/** 
 * check from
 * '1': from reading
 * '2': from library
 * */
if (! in_array($from, ['1', '2'])) {
    header('Location: /404#invalidFromType');
    exit;
}

// get session values
session_start();
$userId = $_SESSION['user_id'];

// enable utf-8
mb_regex_encoding("UTF-8");

$dao = new ToReadDAO();

// check whether or not have edit permission
if (! $dao->checkIfAuthorized($toreadId, $userId)) {
    header('Location: /403');
    exit;
}

// get toread information
// @toread: ToRead object
$toread = $dao->getToReadByToReadId($toreadId);

if (isset($_POST['submit'])) {
    $bookName = $_POST['bookName'];
    $authorName = $_POST['authorName'];
    $memo = $_POST['memo'];
    $currentPage = $_POST['currentPage'];
    $totalPage = $_POST['totalPage'];
    $targetDate = $_POST['targetDate'];
    $colorTag = $_POST['colorTag'];

    // check currentPage
    if (! empty($currentPage)) {
        if (! preg_match('/^[0-9].{0,6}$/', $currentPage)) {
            header('Location: /500#invalidform');
            exit;
        }
    }

    // check totalPage
    if (! empty($totalPage)) {
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

    $_SESSION['from'] = $from;
    $_SESSION['toread_id'] = $toreadId;
    $_SESSION['book_name'] = hescape($bookName);
    $_SESSION['author_name'] = hescape($authorName);
    $_SESSION['memo'] = hescape($memo);
    $_SESSION['current_page'] = hescape($currentPage);
    $_SESSION['total_page'] = hescape($totalPage);
    $_SESSION['target_date'] = hescape($targetDate);
    $_SESSION['color_tag'] = hescape($colorTag);
    // echo 'REDIRECT';
    header('Location: /controller/UpdateBook-controller');
    exit;
}

?>

<?php include('templates/header-nobtn.php'); ?>

<div class="h4 font-yumin text-center m-3">本を編集</div>
<div class="mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div id="appEdit" class="container p-3 p-md-4">
        <form method="POST">
            <div class="form-group pb-1">
                <label>書名（50字以内）</label>
                <textarea type="text" name="bookName" v-model="bookName" class="form-control border-login" rows="1"><?= $toread->getBookName(); ?></textarea>
                <span class="text-danger">{{ error.bookName }}</span>
            </div>
            <div class="form-group pb-1">
                <label>作者名（50字以内）</label>
                <textarea type="text" name="authorName" v-model="authorName" class="form-control border-login" rows="1"><?= $toread->getAuthorName(); ?></textarea>
                <span class="text-danger">{{ error.authorName }}</span>
            </div>
            <div class="form-group pb-1">
                <label>メモ（100字以内）</label>
                <textarea type="text" name="memo" v-model="memo" class="form-control border-login" rows="2"><?= $toread->getMemo(); ?></textarea>
                <span class="text-danger">{{ error.memo }}</span>
            </div>
            <div class="form-row pb-1">
                <div class="form-group col-6 col-md-3">
                    <label>今のページ</label>
                    <input type="number" name="currentPage" v-model="currentPage" class="form-control" value="<?= $toread->getcurrentPage(); ?>">
                    <span class="text-danger">{{ error.currentPage }}</span>
                </div>
                <div class="form-group col-6 col-md-3">
                    <label>全ページ数</label>
                    <input type="number" name="totalPage" v-model="totalPage" class="form-control" value="<?= $toread->getTotalPage(); ?>">
                    <span class="text-danger">{{ error.totalPage }}</span>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label>目標日付</label>
                    <input type="text" id="date" name="targetDate" class="form-control" value="<?= $toread->getTargetDate(); ?>">
                </div>
            </div>
            <div class="form-group pb-1">
                <label>タグ</label>
                <div class="custom-radio btn-group btn-group-toggle d-flex">
                    <input type="radio" name="colorTag" id="option1" value="0" autocomplete="off" <?= $toread->getColorTag()=='0' ? 'checked': '' ?> >
                        <label for="option1" class="btn btn-primary w-100">青</label>
                    <input type="radio" name="colorTag" id="option2" value="1" autocomplete="off" <?= $toread->getColorTag()=='1' ? 'checked': '' ?> >
                        <label for="option2" class="btn btn-danger w-100">赤</label>
                    <input type="radio" name="colorTag" id="option3" value="2" autocomplete="off" <?= $toread->getColorTag()=='2' ? 'checked': '' ?> >
                        <label for="option3" class="btn btn-warning w-100">黄</label>
                    <input type="radio" name="colorTag" id="option4" value="3" autocomplete="off" <?= $toread->getColorTag()=='3' ? 'checked': '' ?> >
                        <label for="option4" class="btn btn-success w-100">緑</label>
                </div>
            </div>
            <button type="submit" name="submit" v-bind:disabled="!isValid" class="btn btn-icon-navy m-2">更新</button>
            <button type="button" class="btn btn-secondary m-2"
                    onClick="location.href=' <?= $from == '1' ? '/controller/Reading-controller?sort=1&id='.$userId : '/controller/Library-controller?sort=1&id='.$userId; ?> '">
                    戻る</button>
            <button type="button" class="btn btn-icon-red float-right m-2" onClick="deleteToread(<?= $toreadId; ?>)">本を削除</button>
        </form>
    </div>
</div>

<?php include('templates/footer-toread.php'); ?>
