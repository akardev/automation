<?php
require_once 'crud.php';
$db=new Crud();

if (!isset($_SESSION['admin']) && isset($_COOKIE['adminLogin'])) {

	$adminLogin=json_decode($_COOKIE['adminLogin']);

	$result=$db->adminLogin($adminLogin->adminUsername, $adminLogin->adminPass, TRUE);

	if ($result['status']) {
		header("Location:index");
		exit;
	}
}

if (!isset($_SESSION['admin']) && !isset($_COOKIE['adminLogin'])) {
	header("Location:login");
	exit;
}
