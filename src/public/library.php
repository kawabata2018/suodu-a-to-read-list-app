<?php

// import class
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

$profile = '';
$errors = array('name'=>'', 'profile'=>'');

// get session values
session_start();
$userId = $_SESSION['user_id'];

// confirm whether or not signed in
if ($_GET['id'] == '' or $userId != $_GET['id']) {
    header('Location: /index.php');
    exit;
}

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$dao->connect();
$user = $dao->getUser($userId);
$dao->close();

?>


<?php include('templates/header-lib.php'); ?>

<!-- <nav class="navbar p-2 navbar-light bg-green-login z-depth-0">
    <div class="container">
        <ul class="navbar-nav">
            <button onClick="signOut()" class="btn btn-sm btn-outline-dark navbar-btn navbar-right lign-middle">Sign out</button>
        </ul>
    </div>
</nav> -->

<nav class="navbar p-0 navbar-light bg-white">
    <div class="container">
            <ul class="nav nav-tabs">
                <li class="nav-item rounded-top ">
                    <a class="nav-link " >未読</a>
                </li>
                <li class="nav-item rounded-top ">
                    <a class="nav-link " >已読</a>
                </li>
                <li class="nav-item rounded-top bg-book">
                    <a class="nav-link " >我</a>
                </li>
            </ul>
    </div>
</nav>

<p class="text-center h4 mt-3"> <?php echo $user->getUserName(); ?>さんの書庫 </p>
<p class="text-center">created at <?php echo $user->getCreatedAt(); ?> </p>

<div class="icon text-center">
    <img src="/public/img/yomimushi.png" alt="よみむし" />
</div>
<div class="container text-right">
    <button onClick="signOut()" class="btn btn-sm btn-secondary">Sign out</button>
</div>

<footer class="section mt-2">
    <div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
</footer>

<script>
function signOut() {
    var res = confirm('ログアウトしますか？');
    if (res) {
        location.replace('logout.php');
    }
}
</script>
<?php include('templates/footer.php'); ?>

