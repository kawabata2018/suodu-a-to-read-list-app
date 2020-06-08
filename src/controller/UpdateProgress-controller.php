<?php

require_once '../dao/ToReadDAO.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];

$dao = new ToReadDAO();

?>