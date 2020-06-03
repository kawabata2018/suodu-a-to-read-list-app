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

<!-- <nav class="navbar p-2 navbar-light bg-green-login z-depth-0">
    <div class="container">
        <ul class="navbar-nav">
            <button onClick="signOut()" class="btn btn-sm btn-outline-dark navbar-btn navbar-right lign-middle">Sign out</button>
        </ul>
    </div>
</nav> -->

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> <?php echo $user->getUserName(); ?>さんの書庫 </p>
    <p class="text-center mt-2"> <?php echo $user->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>

    <p class="text-center mt-0">created at <?php echo $user->getCreatedAt(); ?> </p>

    <div class="text-right">
        <button type="submit" class="btn btn-info" onClick="location.href=' <?php echo '/public/edit-aboutme?id='.$userId; ?> '">編集</button>
    </div>
</div>

<!-- <div class="container text-right">
    <button onClick="signOut()" class="btn btn-sm btn-secondary">Sign out</button>
</div> -->

<?php include('templates/footer-lib.php'); ?>
