<?php

require_once '../dao/UserDAO.php';

// get session values
session_start();
$id = $_SESSION['id'];
$password = $_SESSION['password'];

// unset session values
unset($_SESSION['id']);
unset($_SESSION['password']);

// start login process
$dao = new UserDAO();
/**
 * if the entered id does not match any users,
 * alert that the user does not exist in the db.
 */
$res = $dao->userExistsOrNot($id);

if (! $res) {
    $_SESSION['invalid_id_error'] = 'その読者IDはまだ登録されてないよ';
    header('Location: /public/login');
    exit;

} else {
    $hashedPassword = $dao->getPassword($id);
    if (password_verify($password, $hashedPassword)) {
        /** 
         * logged in sucessfully, store the user_id value
         * into $_SESSION['user_id']
         */
        $_SESSION['user_id'] = $id;
        header('Location: /public/reading?id='.$id);
        exit;

    } else {
        $_SESSION['invalid_password_error'] = 'あいことばが正しくないよ';
        header('Location: /public/login');
        exit;
    }

}

?>