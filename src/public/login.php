<?php

$id = $password = '';
$errors = array('id'=>'', 'password'=>'');

// get session values
session_start();
$invalidIdError = $_SESSION['invalidIdError'];
$invalidPasswordError = $_SESSION['invalidPasswordError'];

// unset session values
unset($_SESSION['id']);
unset($_SESSION['password']);
unset($_SESSION['invalidIdError']);
unset($_SESSION['invalidPasswordError']);

if (isset($_POST['submit'])) {
    // check id
    if (empty($_POST['id'])) {
        $errors['id'] = 'IDを入力してね';
    } else {
        $id = $_POST['id'];
    }

    // check password
    if (empty($_POST['password'])) {
        $errors['password'] = 'あいことばを入力してね';
    } else {
        $password = $_POST['password'];
    }

    if (! array_filter($errors)) {
        $_SESSION['id'] = $id;
        $_SESSION['password'] = $password;
        // echo 'REDIRECT';
        header('Location: /controller/Login-controller.php');
        exit;
    }
}

?>

<?php include('templates/header.php'); ?>

<div class="mt-5 mb-5 d-md-flex flex-items-center gutter-md-spacious">
    <div class="mx-auto col-10 col-sm-6 col-lg-4 hide-sm">
        <div class="rounded-1 text-gray bg-white border-login">
            <div class="container p-3 p-md-4 bg-green-login border-login">
                <span class="h5 font-weight-bolder">書庫に入る</span> <br>
                <span>Login</span>
            </div>
            <div class="container p-3 p-md-4 bg-white border-login">

                <form method="POST">
                    <div class="form-group pb-1">
                        <label>読者ID</label>
                        <input type="text" name="id" class="form-control border-login" placeholder="yomi64"></input>
                        <span class="text-danger"> <?php echo $errors['id']; ?> </span>
                        <span class="text-danger"> <?php echo $invalidIdError; ?> </span>
                    </div>
                    <div class="form-group pb-5">
                        <label>あいことば</label>
                        <input type="password" name="password" class="form-control border-login" placeholder="******"></input>
                        <span class="text-danger"> <?php echo $errors['password']; ?> </span>
                        <span class="text-danger"> <?php echo $invalidPasswordError; ?> </span>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">送信</button>
                </form>

            </div>
            <div class="container p-3 p-md-4 bg-beige-login border-login">
                <span class="d-inline-block">書庫がまだない方は<a href="/public/signup.php">こちら</a></span><span class="d-inline-block">（新規登録）</span>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer.php'); ?>