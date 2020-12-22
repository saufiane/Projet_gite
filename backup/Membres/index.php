<?php require_once("includes/inc_files.php"); 

/*****************************************************************
*    Advanced Membership System   (Shared on www.ARiyan.org)                               *
*    Copyright (c) 2016 Easy-for.com, All Rights Reserved.      *
*****************************************************************/


if($session->is_logged_in()) {
	$user = User::find_by_id($_SESSION['masdyn']['ams']['user_id']);
	if($user->account_lock == 0){$account_lock = "Inactive";} else {$account_lock = "Active";}
}

$current_page = "home";

if(isset($_SESSION['oauth_message'])){
	$message = $_SESSION['oauth_message'];
	unset($_SESSION['oauth_message']);
}

?>

<?php $page_title = "Welcome"; require_once("includes/themes/".THEME_NAME."/header.php"); ?>

<div class="title">
	<h1><?php echo $page_title; ?><h1><a href="http://www.easy-for.com">Shared on www.easy-for.com</a></h1>
</div>

<?php echo output_message($message); ?>

	<br />
	<p>This Advanced Membership System  with the best and easiest way to manage your website users and content.</p>
	<p></p>
	<p>this will allow you to easily customise it to suit your needs.</p>
	<br />
	<p><a href="http://www.easy-for.com" class="btn btn-primary btn-large">Purchase this script &raquo;</a></p>
	

<?php require_once("includes/themes/".THEME_NAME."/footer.php"); ?>