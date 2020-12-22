<?php 

require_once("../includes/inc_files.php"); 
require_once("../includes/classes/admin.class.php");

/*****************************************************************
*    Advanced Member System                                      *
*    Copyright (c) 2013 MasDyn Studio, All Rights Reserved.      *
*****************************************************************/

if($session->is_logged_in()) {
	$user = User::find_by_id($_SESSION['masdyn']['ams']['user_id']);
} else {
	redirect_to("login.php");
}

if(isset($_GET['page'])){
	$page = clean_value($_GET['page']);
} else {
	redirect_to("index.php");
}

$allowed = array('overview','settings','access-levels','token-history','purchase-history','token-bank','access-logs','invites','staff-notes','admin');

if(in_array($page, $allowed)){

	$active_page = "users";
	$admin = User::find_by_id($_SESSION['masdyn']['ams']['user_id']);
	$admin_class = new Admin();
	$user_id = $_GET['user_id'];
	$current_user = User::find_by_id($user_id);
	if(empty($current_user)){
		redirect_to(WWW.ADMINDIR."users.php");
	}

	switch ($page){

		case 'overview':
			$page_url = "users_dashboard/overview.php";
			$page_title = $current_user->first_name." - Account Overview";
		break;

		case 'settings':
			$page_url = "users_dashboard/settings.php";
			$page_title = $current_user->first_name." - Settings";
		break;

		case 'access-levels':
			$page_url = "users_dashboard/access_levels.php";
			$page_title = $current_user->first_name." - Access Levels";
		break;

		case 'token-history':
			$page_url = "users_dashboard/token_history.php";
			$page_title = $current_user->first_name." - Token History";
		break;

		case 'purchase-history':
			$page_url = "users_dashboard/purchase_history.php";
			$page_title = $current_user->first_name." - Purchase History";
		break;

		case 'token-bank':
			$page_url = "users_dashboard/token_bank.php";
			$page_title = $current_user->first_name." - Token Bank";
		break;

		case 'access-logs':
			$page_url = "users_dashboard/access_logs.php";
			$page_title = $current_user->first_name." - Access Logs";
		break;

		case 'invites':
			$page_url = "users_dashboard/invites.php";
			$page_title = $current_user->first_name." - Invites";
			if(ALLOW_REGISTRATIONS == "YES" || ALLOW_INVITES == "NO"){
				redirect_to(WWW.ADMINDIR."user_dashboard.php?page=overviewuser_id=".$user_id);
			}
		break;

		case 'staff-notes':
			$page_url = "users_dashboard/staff_notes.php";
			$page_title = "Staff Notes for $current_user->first_name";
		break;

		case 'admin':
			$page_url = "users_dashboard/admin.php";
			$page_title = "Admin Functions";
		break;

		
		default:
			$page_url = "includes/error/404.php";
			$page_title = "404 - Page Not Found";
		break;

		$location = WWW.ADMINDIR."user_dashboard.php?page=".$page."&user_id=".$user_id;

	}

} else {
	$page_url = "includes/error/404.php";
	$page_title = "404 - Page Not Found";
	$current_page = "error_404";
	$location = WWW."404.php";
}


?>

<?php require_once("../includes/themes/".THEME_NAME."/admin_header.php"); ?>

<div class="title">
	<h1><?php echo $page_title; ?></h1>
</div>

<div class="row-fluid">
	<?php require_once("../includes/global/admin_nav.php"); ?>
</div>

<ul class="nav nav-tabs" style="margin: 0px -11px 11px;">
	<li<?php echo ($page == "overview") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=overview&user_id=".$user_id; ?>">Overview</a></li>
	<li<?php echo ($page == "settings") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=settings&user_id=".$user_id; ?>">Settings</a></li>
	<li<?php echo ($page == "access-levels") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=access-levels&user_id=".$user_id; ?>">Access Levels</a></li>
	<li<?php echo ($page == "token-history") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=token-history&user_id=".$user_id; ?>">Token History</a></li>
	<li<?php echo ($page == "purchase-history") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=purchase-history&user_id=".$user_id; ?>">Purchase History</a></li>
	<li<?php echo ($page == "token-bank") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=token-bank&user_id=".$user_id; ?>">Token Bank</a></li>
	<li<?php echo ($page == "access-logs") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=access-logs&user_id=".$user_id; ?>">Access Logs</a></li>
	<?php if(ALLOW_REGISTRATIONS == "NO" && ALLOW_INVITES == "YES"){ ?><li<?php echo ($page == "invites") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=invites&user_id=".$user_id; ?>">Invites</a></li><?php } ?>
	<li<?php echo ($page == "staff-notes") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=staff-notes&user_id=".$user_id; ?>">Staff Notes</a></li>
	<li<?php echo ($page == "admin") ? ' class="active"' : ''; ?>><a href="<?php echo WWW.ADMINDIR."user_dashboard.php?page=admin&user_id=".$user_id; ?>">Admin</a></li>
</ul>


<div id="message"><?php echo output_message($message); ?></div>

<?php require_once($page_url); ?>

<?php require_once("../includes/themes/".THEME_NAME."/footer.php"); ?>