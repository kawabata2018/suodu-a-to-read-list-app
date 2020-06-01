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

// confirm whether or not signed in
if ($_GET['id'] == '' or $userId != $_GET['id']) {
    header('Location: /');
}

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$dao->connect();
$user = $dao->getUser($userId);
$dao->close();


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
        header('Location: /controller/Aboutme-controller?id='.$userId);
        exit;
    }
}

?>

<?php include('templates/header-nobtn.php'); ?>

<div class="mt-5 mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div class="container p-3 p-md-4">

    <form method="POST">
        <div class="form-group pb-1">
            <label>読者名（20字以内）</label>
            <textarea type="text" name="name" class="form-control border-login" rows="1"><?php echo $user->getUserName(); ?></textarea>
            <span class="text-danger"> <?php echo $errors['name']; ?> </span>
        </div>
        <div class="form-group pb-1">
            <label>自己紹介（100字以内）</label>
            <textarea type="text" name="profile" class="form-control border-login" rows="4"><?php echo $user->getProfile(); ?></textarea>
            <span class="text-danger"> <?php echo $errors['profile']; ?> </span>
        </div>
        <!-- <div class="form-group pb-1">
            <label class="text-muted">アイコン選択（coming soon ...）</label>
        </div> -->
        <div class="form-group custom-control custom-checkbox pb-1">
            <input type="checkbox" class="custom-control-input" id="publishOrNot" name="publishOrNot">
            <label class="custom-control-label" for="publishOrNot">自分の書庫を公開する</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary m-2">更新</button>
    </form>
    <div class="text-right">
        <a class="text-info text-small" <?php echo 'href="/public/library?id='.$userId.'"'; ?> >更新せずに戻る</a>
    </div>

    </div>
</div>

<footer class="section mt-2">
    <div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
</footer>
<?php include('templates/footer.php'); ?>