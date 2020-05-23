<?php

// import class
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

$profile = '';
$errors = array('name'=>'', 'profile'=>'');

// get session values
session_start();
$id = $_SESSION['id'];


// confirm whether or not signed in
if ($_GET['id'] == '' or $id != $_GET['id']) {
    header('Location: /index.php');
}

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$dao->connect();
$user = $dao->getUser($id);
$dao->close();

?>


<?php include('templates/header.php'); ?>
<nav class="navbar p-2 navbar-expand-lg navbar-light flex-column flex-md-row bg-green-login z-depth-0">
    <ul class="navbar-nav">
        <a class="navbar-brand">
            <span class="align-middle text-white h5"> <?php echo $user->getUserName(); ?>さんの書庫 </span>
        </a>
        <!-- <li class="nav-item">
            <a href="/public/login.php">ログイン</a>
        </li> -->
    </ul>
</nav>

<p class="text-center mt-3">created at <?php echo $user->getCreatedAt(); ?> </p>

<div class="icon text-center">
    <img src="/public/img/yomimushi.png" alt="よみむし" />
</div>

<?php include('templates/footer.php'); ?>