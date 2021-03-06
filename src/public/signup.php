<?php

// import class
require_once 'templates/escape-func.php';

$id = $password1 = $password2 = '';
$errors = array('id'=>'', 'password1'=>'', 'password2'=>'');

// get session values
session_start();
$userExistsError = $_SESSION['user_exists_error'];

// unset session values
unset($_SESSION['id']);
unset($_SESSION['password']);
unset($_SESSION['user_exists_error']);

if (isset($_POST['submit'])) {
    // check id
    if (empty($_POST['id'])) {
        $errors['id'] = 'IDを入力してね';
    } else {
        $id = $_POST['id'];
        if (!preg_match('/^[a-zA-Z0-9_]{4,12}$/', $id)) {
            $errors['id'] = '英数4-12文字で入力してね';
        }
    }

    // check password1
    if (empty($_POST['password1'])) {
        $errors['password1'] = 'あいことばを入力してね';
    } else {
        $password1 = $_POST['password1'];
        if (!preg_match('/^[a-zA-Z0-9_]{4,12}$/', $password1)) {
            $errors['password1'] = '英数4-12文字で入力してね';
        }
    }

    // check password2
    if ($_POST['password1'] != $_POST['password2']) {
        $errors['password2'] = 'あいことばが一致しないよ';
    }

    if (! array_filter($errors)) {
        $_SESSION['id'] = hescape($id);
        $_SESSION['password'] = hescape($password1);
        // echo 'REDIRECT';
        header('Location: /controller/Signup-controller');
        exit;
    }
}

?>

<?php include('templates/header-nobtn.php'); ?>

<div class="mt-5 mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div class="mx-auto col-10 col-sm-6 col-lg-4 hide-sm">
        <div class="rounded-1 bg-white border-login box-shadow-2">
            <div class="container p-3 p-md-4 bg-icon-red border-login">
                <span class="h5 font-weight-bolder">書庫をつくる</span> <br>
                <span>Sign up</span>
            </div>
            <div class="container p-3 p-md-4 bg-white border-login">

            <form method="POST">
                <div class="form-group pb-1">
                    <label>読者ID（英数4-12文字）<span class="text-small">*IDは変更できません</span> </label>
                    <input type="text" name="id" class="form-control border-login" placeholder=""></input>
                    <span class="text-danger"> <?= $errors['id']; ?> </span>
                    <span class="text-danger"> <?= $userExistsError; ?> </span>
                </div>
                <div class="form-group pb-1">
                    <label>あいことば（英数4-12文字）</label>
                    <input type="password" name="password1" class="form-control border-login" placeholder=""></input>
                    <span class="text-danger"> <?= $errors['password1']; ?> </span>
                </div>
                <div class="form-group pb-5">
                    <label>あいことば（確認）</label>
                    <input type="password" name="password2" class="form-control border-login" placeholder=""></input>
                    <span class="text-danger"> <?= $errors['password2']; ?> </span>
                </div>
                <button type="submit" name="submit" class="btn btn-icon-navy">登録</button>
            </form>

            </div>
            <div class="container p-3 p-md-4 bg-beige-login border-login">
                <span class="d-inline-block">Already signed up?</span>
                <span class="d-inline-block"><a href="/public/login">Login here</a> instead.</span>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer.php'); ?>
