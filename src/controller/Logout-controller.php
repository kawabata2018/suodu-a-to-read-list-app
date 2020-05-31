<?php

// get session values
session_start();

// unset session values
unset($_SESSION['user_id']);

// go back to index
header('Location: /');
exit;

?>