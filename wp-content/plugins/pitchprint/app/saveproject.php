<?php
	session_start();
	//YOU CAN HANDLE SESSIONING HERE....
	require_once('../../../../wp-load.php');
	
	if (isset($_REQUEST['clear'])) {
		if (isset($_SESSION['pp_projects'])) {		
			if (isset($_SESSION['pp_projects'][$_GET['productID']])) {
				unset($_SESSION['pp_projects'][$_GET['productID']]);
			}
		}
		exit();
	}
	if (!isset($_SESSION['pp_projects'])) {
		$_SESSION['pp_projects'] = array();
		$_SESSION['pp_projects'][$_GET['productID']] = array();
	} else if (!isset($_SESSION['pp_projects'][$_GET['productID']])) {
		$_SESSION['pp_projects'][$_GET['productID']] = array();
	}
		
	$_SESSION['pp_projects'][$_GET['productID']] = $_POST['values'];
	
	if (isset($_POST['clone'])) {
		echo get_permalink($_GET['productID']);
	}
?>