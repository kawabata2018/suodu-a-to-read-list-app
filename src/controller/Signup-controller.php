<?php

require_once '../dao/UserDAO.php';

// get session values
session_start();
$id = $_SESSION['id'];
$password = $_SESSION['password'];

// unset session values
unset($_SESSION['id']);
unset($_SESSION['password']);

$dao = new UserDAO();
/**
 * if the entered id already exists,
 * alert that they should sign up using other ids.
 */
$res1 = $dao->userExistsOrNot($id);

if ($res1) {
    $_SESSION['user_exists_error'] = 'その読者IDはすでに存在するよ';
    header('Location: /public/signup');
    exit;

} else {
    $res2 = $dao->createUser($id, $password);
    if ($res2) {
        /** 
         * signed up sucessfully, store the user_id value
         * into $_SESSION['user_id']
         */
        $_SESSION['user_id'] = $id;
        header('Location: /public/welcome?id=' . $id);
        exit;
    } else {
        // echo '<br>アカウント作成に失敗しました。';
        header('Location: /500');
        exit;
    }

}

?>