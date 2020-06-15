<?php

// import class
require_once 'templates/escape-func.php';
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

$errors = array('name'=>'', 'profile'=>'');

// get session values
session_start();
$userId = $_SESSION['user_id'];

// unset session values
unset($_SESSION['name']);
unset($_SESSION['profile']);
unset($_SESSION['publish_or_not']);

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$user = $dao->getUser($userId);


if (isset($_POST['submit'])) {
    // check name
    $name = $_POST['name'];
    if (!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。].{0,20}$/u', $name)) {
        $errors['name'] = '20字以内で入力してね';
    }

    // check profile
    $profile = $_POST['profile'];
    if (!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。\r\n].{0,100}$/u', $profile)) {
        $errors['profile'] = '100字以内で入力してね';
    }

    // 'on' or 'off'
    $publishOrNot = 'off'; // default
    $publishOrNot = $_POST['publishOrNot']; // 'on' when checked
    if (!array_filter($errors)) {
        $_SESSION['name'] = hescape($name);
        $_SESSION['profile'] = hescape($profile);
        $_SESSION['publish_or_not'] = hescape($publishOrNot);
        // echo 'REDIRECT';
        header('Location: /controller/Aboutme-controller');
        exit;
    }
}

?>

<?php include('templates/header-nobtn.php'); ?>

<div class="h4 font-yumin text-center m-3">プロフィールを編集</div>
<div class="mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div class="container p-3 p-md-4">
        <form method="POST">
            <div class="form-group pb-1">
                <label>読者名（20字以内）</label>
                <textarea type="text" name="name" class="form-control border-login" rows="1"><?= $user->getUserName(); ?></textarea>
                <span class="text-danger"> <?= $errors['name']; ?> </span>
            </div>
            <div class="form-group pb-1">
                <label>自己紹介（100字以内）</label>
                <textarea type="text" name="profile" class="form-control border-login" rows="4"><?= $user->getProfile(); ?></textarea>
                <span class="text-danger"> <?= $errors['profile']; ?> </span>
            </div>
            <!-- <div class="form-group pb-1">
                <label class="text-muted">アイコン選択（coming soon ...）</label>
            </div> -->
            <div class="form-group custom-control custom-switch pb-1">
                <input type="checkbox" class="custom-control-input" id="publishOrNot" name="publishOrNot" <?= $user->getIsProtected() == '0' ? 'checked': '' ?> >
                <label class="custom-control-label" for="publishOrNot">自分の書庫を公開する</label>
            </div>
            <button type="submit" name="submit" class="btn btn-icon-navy m-2">更新</button>
            <button type="button" class="btn btn-secondary m-2" onClick="location.href=' <?= '/public/aboutme?id='.$userId; ?> '">戻る</button>
        </form>
    </div>
</div>

<?php include('templates/footer.php'); ?>
