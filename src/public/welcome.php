<?php

// import class
require_once 'templates/escape-func.php';

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

if (isset($_POST['submit'])) {
    // check name
    $name = $_POST['name'];
    if (!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。\r\n].{0,20}$/u', $name)) {
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
        header('Location: /controller/Welcome-controller.php?id='.$userId);
        exit;
    }
}

?>

<?php include('templates/header-nobtn.php'); ?>

<div class="mt-5 mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div class="mx-auto col-10 col-sm-6 col-lg-4 hide-sm">
        <div class="text-center">
            <p class="h4 font-weight-bolder">登録完了！</p>
            <p>あなただけの書庫ができあがりました</p>
        </div>
        <div class="rounded-1 bg-white border-login">
            <div class="container p-3 p-md-4 bg-red-login border-login">
                <span class="h5 font-weight-bolder">プロフィール登録</span> <br>
                <!-- <span>Sign up</span> -->
            </div>
            <div class="container p-3 p-md-4 bg-white border-login">

            <form method="POST">
                <div class="form-group pb-1">
                    <label>読者名（20字以内）</label>
                    <textarea type="text" name="name" class="form-control border-login" rows="1" placeholder="よみむし"></textarea>
                    <span class="text-danger"> <?php echo $errors['name']; ?> </span>
                </div>
                <div class="form-group pb-1">
                    <label>自己紹介（100字以内）</label>
                    <textarea type="text" name="profile" class="form-control border-login" rows="4" placeholder="よみむしくんは本の虫"></textarea>
                    <span class="text-danger"> <?php echo $errors['profile']; ?> </span>
                </div>
                <!-- <div class="form-group pb-1">
                    <label class="text-muted">アイコン選択（coming soon ...）</label>
                </div> -->
                <div class="form-group custom-control custom-checkbox pb-5">
                    <input type="checkbox" class="custom-control-input" id="publishOrNot" name="publishOrNot">
                    <label class="custom-control-label" for="publishOrNot">自分の書庫を公開する</label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">登録</button>
            </form>

            </div>
            <div class="container p-3 p-md-4 bg-beige-login border-login">
                <span class="d-inline-block">プロフィール登録はスキップできます</span>
                <span class="d-inline-block"><a <?php echo 'href="/public/library?id='.$userId.'"'; ?> >あとで</a></span>
            </div>
        </div>
    </div>
</div>

<footer class="section mt-2">
    <div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
</footer>
<?php include('templates/footer.php'); ?>