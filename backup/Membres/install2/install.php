﻿<?php 
/*****************************************************************
*    MDS Installer for Advanced Member System                    *
*    Copyright (c) 2013 MasDyn Studio, All Rights Reserved.      *
*****************************************************************/
ob_start();
ob_clean();
session_start();
$pzdinolm0="install.php";
$qxoamrnf1="Advanced Member System";
$ferodmcy2="3.5";
$avviftbo3="3";
function preprint($gwwpnwtx4)
{
	echo "<pre>";print_r($gwwpnwtx4);echo "</pre>";
}
function clean_value($rakehieb5)
{
	global $hjkmiysb6;
	return preg_replace("/[^0-9a-z_ ,.(){}-]/i","",trim($rakehieb5));
}
function create_salt($bxqqxroy7=25)
{
	$tkmfvpze8=array_merge(range('A','Z'),range('a','z'),range(0,9));$fdixgxbk9='';
	for($cnucqgsb10=0;$cnucqgsb10<$bxqqxroy7;$cnucqgsb10++)
	{
		$fdixgxbk9.=$tkmfvpze8[mt_rand(0,count($tkmfvpze8)-1)];
	}
	return $fdixgxbk9;
}
function encrypt_password($zypsvswc11,$mqdcsptq12="")
{
	$drkplhmd13=10;
	if($mqdcsptq12=="")
	{
		$mqdcsptq12=$_SESSION['installer']['fresh']['core']['DATABASE_SALT'];
	}
	$ohwnunvy14=crypt($zypsvswc11,$mqdcsptq12);
	for($nysvqtur15=0;$nysvqtur15<$drkplhmd13;++$nysvqtur15)
	{
		$ohwnunvy14=crypt($ohwnunvy14.$zypsvswc11,$mqdcsptq12);
	}
	return $ohwnunvy14;
}
function generate_id($jsdhpxpk16=6){$cykivxxf17='';for($nysvqtur15=0;$nysvqtur15<$jsdhpxpk16;$nysvqtur15++)
	{
		$cykivxxf17.=rand(1,9);
	}
	return $cykivxxf17;
}

if(!isset($_SESSION['installer']['fresh']['message']))
{
	$smbhfywz18="";
}
else
{
	$smbhfywz18=$_SESSION['installer']['fresh']['message'];
	unset($_SESSION['installer']['fresh']['message']);
}
if(!isset($_SESSION['installer']['fresh']))
{
	$_SESSION['installer']['fresh']['step']=1;
	$_SESSION['installer']['fresh']['completed']=array();
}
if(!isset($_GET['step']))
{
	$npoxzxyj19=1;
}
else
{
	$npoxzxyj19=$_GET['step'];
}
$sltsbckv20=$_SESSION['installer']['fresh']['step'];
if($npoxzxyj19>$sltsbckv20)
{
	header("location: install.php?step=$sltsbckv20");
}
if($npoxzxyj19==1)
{
	$pzdinolm0="install.php?step=1";
	$uwcsafuf21=null;
	if(isset($_POST['submit']))
	{
		$_SESSION['installer']['fresh']['step']=2;
		$_SESSION['installer']['fresh']['completed'][]=1;
		header("location: install.php?step=2");
	}
}

else if($npoxzxyj19==2)
{
	$pzdinolm0="install.php?step=2";
	if(isset($_POST['submit']))
	{
		$khanyzot22=$_POST['host'];
		$rrcqkahd23=$_POST['user'];
		$msakceez24=$_POST['pass'];
		$hjkmiysb6=$_POST['database'];
		$nwlmtamd25=false;
		if($khanyzot22!="" &&$rrcqkahd23!="" &&$hjkmiysb6!="")
		{
			$xxuaqwse26=mysql_connect($khanyzot22,$rrcqkahd23,$msakceez24);
			if(!$xxuaqwse26)
			{
				$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Could not connect: ".mysql_error()."</div>";
				$nwlmtamd25=true;
			}
			else
			{
				$pwtsnmsr27=mysql_select_db($hjkmiysb6,$xxuaqwse26);
				if(!$pwtsnmsr27)
				{
					$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Can't use $hjkmiysb6: ".mysql_error()."</div>";$nwlmtamd25=true;
				}
			}
			if($nwlmtamd25===false)
			{
				$_SESSION['installer']['fresh']['database']=array('host' =>$khanyzot22,'user' =>$rrcqkahd23,'pass' =>$msakceez24,'database' =>$hjkmiysb6);
				$_SESSION['installer']['fresh']['step']=3;
				$_SESSION['installer']['fresh']['completed'][]=2;
				$_SESSION['installer']['fresh']['message']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Successfully connected to database: <strong>$hjkmiysb6</strong>.</div>";
				header("location: install.php?step=3");
			}
		}
		else
		{
			$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Please complete all required fields.</div>";
		}
	}
	else
	{
		if(isset($_SESSION['installer']['fresh']['database']))
		{
			$khanyzot22=$_SESSION['installer']['fresh']['database']['host'];
			$rrcqkahd23=$_SESSION['installer']['fresh']['database']['user'];
			$msakceez24=$_SESSION['installer']['fresh']['database']['pass'];
			$hjkmiysb6=$_SESSION['installer']['fresh']['database']['database'];
		}
		else
		{
			$khanyzot22="";
			$rrcqkahd23="";
			$msakceez24="";
			$hjkmiysb6="";
		}
	}
}
else if($npoxzxyj19==3)
{
	$pzdinolm0="install.php?step=3";
	if(isset($_POST['submit']))
	{
		$uwcsafuf21=null;
		$khanyzot22=$_SESSION['installer']['fresh']['database']['host'];
		$rrcqkahd23=$_SESSION['installer']['fresh']['database']['user'];
		$msakceez24=$_SESSION['installer']['fresh']['database']['pass'];
		$hjkmiysb6=$_SESSION['installer']['fresh']['database']['database'];
		$xxuaqwse26=mysql_connect($khanyzot22,$rrcqkahd23,$msakceez24);
		if(!$xxuaqwse26)
		{
			die('Could not connect: '.mysql_error());
		}
		$pwtsnmsr27=mysql_select_db($hjkmiysb6,$xxuaqwse26);
		if(!$pwtsnmsr27){die('Can\'t use '.$hjkmiysb6.' : '.mysql_error());
		}
		if(mysql_query("DROP DATABASE ".$hjkmiysb6))
		{
			if(mysql_query("CREATE DATABASE `".$hjkmiysb6."`"))
			{
				mysql_select_db($hjkmiysb6,$xxuaqwse26);
				foreach(file("fresh_database.sql") as $celphero28){mysql_query($celphero28);
				}
				mysql_close($xxuaqwse26);
				$xslnndgs29='../includes/configuration/config.php';

				$gawgxepu3='<?php

if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) exit("No direct access allowed.");

/*****************************************************************
*                                                                *
*    MasDyn Studio - Advanced Member System                      *
*    Copyright (c) 2013 MasDyn Studio, All Rights Reserved.      *
*    Release Date: 22-07-2013                                    *
*    Version: 3.5                                                *
*                                                                *
*    Website: http://www.masdyn.com                              *
*    Support: http://www.masdyn.com/support/                     *
*                                                                *
*****************************************************************/

ob_start();
ob_clean();
session_start();
defined("DB_SERVER") ? null : define("DB_SERVER", "'.$khanyzot22.'");
defined("DB_USER")   ? null : define("DB_USER", "'.$rrcqkahd23.'");
defined("DB_PASS")   ? null : define("DB_PASS", "'.$msakceez24.'");
defined("DB_NAME")   ? null : define("DB_NAME", "'.$hjkmiysb6.'");
require("core_settings.class.php");
$core_settings = Core_Settings::find_by_sql("SELECT * FROM core_settings");
$count = count($core_settings);
for($i=0;$i <= $count-1;$i++){
	defined($core_settings[$i]->name) ? null : define($core_settings[$i]->name, $core_settings[$i]->data);
}
defined("IMAGES") ? null : define("IMAGES", WWW."img/"); 
date_default_timezone_set(TIMEZONE);

defined("RECAPTCHA_PUBLIC")   ? null : define("RECAPTCHA_PUBLIC", "");
defined("RECAPTCHA_PRIVATE")   ? null : define("RECAPTCHA_PRIVATE", "");

defined("AUTHPATH")   ? null : define("AUTHPATH", "/auth/");
defined("AUTHSALT")   ? null : define("AUTHSALT", "PASTE_RANDOM_CODE_HERE");

defined("FACEBOOK_APP_ID")   ? null : define("FACEBOOK_APP_ID", "");
defined("FACEBOOK_APP_SECRET")   ? null : define("FACEBOOK_APP_SECRET", "");

defined("TWITTER_CONSUMER_KEY")   ? null : define("TWITTER_CONSUMER_KEY", "");
defined("TWITTER_CONSUMER_SECRET")   ? null : define("TWITTER_CONSUMER_SECRET", "");

defined("GOOGLE_CLIENT_ID")   ? null : define("GOOGLE_CLIENT_ID", "");
defined("GOOGLE_CLIENT_SECRET")   ? null : define("GOOGLE_CLIENT_SECRET", "");

// OAuth Database Codes
// 0 = Facebook
// 1 = Twitter
// 2 = Google


?>
';
if(!$cajjcmbx31=fopen($xslnndgs29,'w'))
{
	echo"Cannot open file ($xslnndgs29)";
	exit;
}
	if(fwrite($cajjcmbx31,$gawgxepu3)===FALSE)
	{
		echo"Cannot write to file ($xslnndgs29)";exit;
	}
		else
		{
			fclose($cajjcmbx31);
			$_SESSION['installer']['fresh']['step']=4;
			$_SESSION['installer']['fresh']['completed'][]=3;
			$_SESSION['installer']['fresh']['message']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>All of the tables have been successfully added to <strong>$hjkmiysb6</strong> database.</div>";
			header("location: install.php?step=4");
		}
	}
			else
			{
				$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>There was an error when we tried to create ".$hjkmiysb6.".</div>";
			}
		}
				else
				{
					$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>There was an error when we tried to delete ".$hjkmiysb6.".</div>";
				}
		}
	}
		else if($npoxzxyj19==4)
		{
			$pzdinolm0="install.php?step=4";
			$dvceaqik32=array('(GMT-12:00) International Date Line West' =>'Pacific/Wake','(GMT-11:00) Midway Island' =>'Pacific/Apia','(GMT-11:00) Samoa' =>'Pacific/Apia','(GMT-10:00) Hawaii' =>'Pacific/Honolulu','(GMT-09:00) Alaska' =>'America/Anchorage','(GMT-08:00) Pacific Time (US &amp; Canada); Tijuana' =>'America/Los_Angeles','(GMT-07:00) Arizona' =>'America/Phoenix','(GMT-07:00) Chihuahua' =>'America/Chihuahua','(GMT-07:00) La Paz' =>'America/Chihuahua','(GMT-07:00) Mazatlan' =>'America/Chihuahua','(GMT-07:00) Mountain Time (US &amp; Canada)' =>'America/Denver','(GMT-06:00) Central America' =>'America/Managua','(GMT-06:00) Central Time (US &amp; Canada)' =>'America/Chicago','(GMT-06:00) Guadalajara' =>'America/Mexico_City','(GMT-06:00) Mexico City' =>'America/Mexico_City','(GMT-06:00) Monterrey' =>'America/Mexico_City','(GMT-06:00) Saskatchewan' =>'America/Regina','(GMT-05:00) Bogota' =>'America/Bogota','(GMT-05:00) Eastern Time (US &amp; Canada)' =>'America/New_York','(GMT-05:00) Indiana (East)' =>'America/Indiana/Indianapolis','(GMT-05:00) Lima' =>'America/Bogota','(GMT-05:00) Quito' =>'America/Bogota','(GMT-04:00) Atlantic Time (Canada)' =>'America/Halifax','(GMT-04:00) Caracas' =>'America/Caracas','(GMT-04:00) La Paz' =>'America/Caracas','(GMT-04:00) Santiago' =>'America/Santiago','(GMT-03:30) Newfoundland' =>'America/St_Johns','(GMT-03:00) Brasilia' =>'America/Sao_Paulo','(GMT-03:00) Buenos Aires' =>'America/Argentina/Buenos_Aires','(GMT-03:00) Georgetown' =>'America/Argentina/Buenos_Aires','(GMT-03:00) Greenland' =>'America/Godthab','(GMT-02:00) Mid-Atlantic' =>'America/Noronha','(GMT-01:00) Azores' =>'Atlantic/Azores','(GMT-01:00) Cape Verde Is.' =>'Atlantic/Cape_Verde','(GMT) Casablanca' =>'Africa/Casablanca','(GMT) Edinburgh' =>'Europe/London','(GMT) Greenwich Mean Time : Dublin' =>'Europe/London','(GMT) Lisbon' =>'Europe/London','(GMT) London' =>'Europe/London','(GMT) Monrovia' =>'Africa/Casablanca','(GMT+01:00) Amsterdam' =>'Europe/Berlin','(GMT+01:00) Belgrade' =>'Europe/Belgrade','(GMT+01:00) Berlin' =>'Europe/Berlin','(GMT+01:00) Bern' =>'Europe/Berlin','(GMT+01:00) Bratislava' =>'Europe/Belgrade','(GMT+01:00) Brussels' =>'Europe/Paris','(GMT+01:00) Budapest' =>'Europe/Belgrade','(GMT+01:00) Copenhagen' =>'Europe/Paris','(GMT+01:00) Ljubljana' =>'Europe/Belgrade','(GMT+01:00) Madrid' =>'Europe/Paris','(GMT+01:00) Paris' =>'Europe/Paris','(GMT+01:00) Prague' =>'Europe/Belgrade','(GMT+01:00) Rome' =>'Europe/Berlin','(GMT+01:00) Sarajevo' =>'Europe/Sarajevo','(GMT+01:00) Skopje' =>'Europe/Sarajevo','(GMT+01:00) Stockholm' =>'Europe/Berlin','(GMT+01:00) Vienna' =>'Europe/Berlin','(GMT+01:00) Warsaw' =>'Europe/Sarajevo','(GMT+01:00) West Central Africa' =>'Africa/Lagos','(GMT+01:00) Zagreb' =>'Europe/Sarajevo','(GMT+02:00) Athens' =>'Europe/Istanbul','(GMT+02:00) Bucharest' =>'Europe/Bucharest','(GMT+02:00) Cairo' =>'Africa/Cairo','(GMT+02:00) Harare' =>'Africa/Johannesburg','(GMT+02:00) Helsinki' =>'Europe/Helsinki','(GMT+02:00) Istanbul' =>'Europe/Istanbul','(GMT+02:00) Jerusalem' =>'Asia/Jerusalem','(GMT+02:00) Kyiv' =>'Europe/Helsinki','(GMT+02:00) Minsk' =>'Europe/Istanbul','(GMT+02:00) Pretoria' =>'Africa/Johannesburg','(GMT+02:00) Riga' =>'Europe/Helsinki','(GMT+02:00) Sofia' =>'Europe/Helsinki','(GMT+02:00) Tallinn' =>'Europe/Helsinki','(GMT+02:00) Vilnius' =>'Europe/Helsinki','(GMT+03:00) Baghdad' =>'Asia/Baghdad','(GMT+03:00) Kuwait' =>'Asia/Riyadh','(GMT+03:00) Moscow' =>'Europe/Moscow','(GMT+03:00) Nairobi' =>'Africa/Nairobi','(GMT+03:00) Riyadh' =>'Asia/Riyadh','(GMT+03:00) St. Petersburg' =>'Europe/Moscow','(GMT+03:00) Volgograd' =>'Europe/Moscow','(GMT+03:30) Tehran' =>'Asia/Tehran','(GMT+04:00) Abu Dhabi' =>'Asia/Muscat','(GMT+04:00) Baku' =>'Asia/Tbilisi','(GMT+04:00) Muscat' =>'Asia/Muscat','(GMT+04:00) Tbilisi' =>'Asia/Tbilisi','(GMT+04:00) Yerevan' =>'Asia/Tbilisi','(GMT+04:30) Kabul' =>'Asia/Kabul','(GMT+05:00) Ekaterinburg' =>'Asia/Yekaterinburg','(GMT+05:00) Islamabad' =>'Asia/Karachi','(GMT+05:00) Karachi' =>'Asia/Karachi','(GMT+05:00) Tashkent' =>'Asia/Karachi','(GMT+05:30) Chennai' =>'Asia/Calcutta','(GMT+05:30) Kolkata' =>'Asia/Calcutta','(GMT+05:30) Mumbai' =>'Asia/Calcutta','(GMT+05:30) New Delhi' =>'Asia/Calcutta','(GMT+05:45) Kathmandu' =>'Asia/Katmandu','(GMT+06:00) Almaty' =>'Asia/Novosibirsk','(GMT+06:00) Astana' =>'Asia/Dhaka','(GMT+06:00) Dhaka' =>'Asia/Dhaka','(GMT+06:00) Novosibirsk' =>'Asia/Novosibirsk','(GMT+06:00) Sri Jayawardenepura' =>'Asia/Colombo','(GMT+06:30) Rangoon' =>'Asia/Rangoon','(GMT+07:00) Bangkok' =>'Asia/Bangkok','(GMT+07:00) Hanoi' =>'Asia/Bangkok','(GMT+07:00) Jakarta' =>'Asia/Bangkok','(GMT+07:00) Krasnoyarsk' =>'Asia/Krasnoyarsk','(GMT+08:00) Beijing' =>'Asia/Hong_Kong','(GMT+08:00) Chongqing' =>'Asia/Hong_Kong','(GMT+08:00) Hong Kong' =>'Asia/Hong_Kong','(GMT+08:00) Irkutsk' =>'Asia/Irkutsk','(GMT+08:00) Kuala Lumpur' =>'Asia/Singapore','(GMT+08:00) Perth' =>'Australia/Perth','(GMT+08:00) Singapore' =>'Asia/Singapore','(GMT+08:00) Taipei' =>'Asia/Taipei','(GMT+08:00) Ulaan Bataar' =>'Asia/Irkutsk','(GMT+08:00) Urumqi' =>'Asia/Hong_Kong','(GMT+09:00) Osaka' =>'Asia/Tokyo','(GMT+09:00) Sapporo' =>'Asia/Tokyo','(GMT+09:00) Seoul' =>'Asia/Seoul','(GMT+09:00) Tokyo' =>'Asia/Tokyo','(GMT+09:00) Yakutsk' =>'Asia/Yakutsk','(GMT+09:30) Adelaide' =>'Australia/Adelaide','(GMT+09:30) Darwin' =>'Australia/Darwin','(GMT+10:00) Brisbane' =>'Australia/Brisbane','(GMT+10:00) Canberra' =>'Australia/Sydney','(GMT+10:00) Guam' =>'Pacific/Guam','(GMT+10:00) Hobart' =>'Australia/Hobart','(GMT+10:00) Melbourne' =>'Australia/Sydney','(GMT+10:00) Port Moresby' =>'Pacific/Guam','(GMT+10:00) Sydney' =>'Australia/Sydney','(GMT+10:00) Vladivostok' =>'Asia/Vladivostok','(GMT+11:00) Magadan' =>'Asia/Magadan','(GMT+11:00) New Caledonia' =>'Asia/Magadan','(GMT+11:00) Solomon Is.' =>'Asia/Magadan','(GMT+12:00) Auckland' =>'Pacific/Auckland','(GMT+12:00) Fiji' =>'Pacific/Fiji','(GMT+12:00) Kamchatka' =>'Pacific/Fiji','(GMT+12:00) Marshall Is.' =>'Pacific/Fiji','(GMT+12:00) Wellington' =>'Pacific/Auckland','(GMT+13:00) Nuku\'alofa' =>'Pacific/Tongatapu',);
		if(isset($_POST['submit']))
		{
			$rblyunyw33=trim($_POST['WWW']);
			$hzyhesrf34=trim($_POST['SITE_NAME']);
			$xyrdzwiw35=trim($_POST['SITE_DESC']);
			$kuhfybra36=trim($_POST['SITE_KEYW']);
			$swotethg37=trim($_POST['ADMINDIR']);
			$bdbfrztg38=trim($_POST['SITE_EMAIL']);
			$eiggaoxd39=trim($_POST['VERIFY_EMAIL']);
			$tuizqean40=trim($_POST['ALLOW_REGISTRATIONS']);
			$sacgvbji41=trim($_POST['CURRENCY_CODE']);
			$encmyzaa42=trim($_POST['CURRENCYSYMBOL']);
			$dnucpcim43=trim($_POST['PAYPAL_SANDBOX']);
			$pvmzngxw44=trim($_POST['PAYPAL_EMAIL']);
			$lzsesxfm45=trim($_POST['DATABASE_SALT']);
			$ieypjqkg46=trim($_POST['PAGINATION_PER_PAGE']);
			$tbqupicv47=trim($_POST['TIMEZONE']);
			$btmzfthz48="YES";
			$dsoyyntn49=trim($_POST['TOKEN_PRICE']);
			$kmtcuwml50=trim($_POST['MAX_INVITES']);
			$xchxejwv51=trim($_POST['ALLOW_INVITES']);
			$jqpdpavr52=trim($_POST['OAUTH']);
			$zfdnwwwp53=trim($_POST['ADMIN_LEVEL']);
			$lzuucrpr54=trim($_POST['THEME_NAME']);
			$xevfwsny55=trim($_POST['BRUTEFORCE_LIMIT']);
			$wgniqsdh56=trim($_POST['BRUTEFORCE_TIMEOUT']);
			$fjlgqodu57=trim($_POST['CAPTCHA']);
			$bnayxhys58=trim($_POST['CAPTCHA_TYPE']);
			$kijefkbw59=trim($_POST['PP_SERVICE_PURCHASE']);
			if($rblyunyw33!="" &&$hzyhesrf34!="" &&$swotethg37!="" &&$bdbfrztg38!="" &&$eiggaoxd39!="" &&$tuizqean40!="" &&$sacgvbji41!="" &&$encmyzaa42!="" &&$dnucpcim43!="" &&$pvmzngxw44!="" &&$sacgvbji41!="" &&$encmyzaa42!="" &&$lzsesxfm45!="" &&$ieypjqkg46!="" &&$tbqupicv47!="" &&$btmzfthz48!="" &&$kmtcuwml50!="" &&$xchxejwv51!="" &&$jqpdpavr52!="" &&$zfdnwwwp53!="" &&$lzuucrpr54!="" &&$xevfwsny55!="" &&$wgniqsdh56!="" &&$fjlgqodu57!="" &&$bnayxhys58!="" &&$kijefkbw59!="")
			{
				$xzphrsoy60='';
			for($nysvqtur15=0;$nysvqtur15<6;$nysvqtur15++)
			{
				$xzphrsoy60.=rand(1,9);
			}
			$khanyzot22=$_SESSION['installer']['fresh']['database']['host'];$rrcqkahd23=$_SESSION['installer']['fresh']['database']['user'];$msakceez24=$_SESSION['installer']['fresh']['database']['pass'];$hjkmiysb6=$_SESSION['installer']['fresh']['database']['database'];$xxuaqwse26=mysql_connect($khanyzot22,$rrcqkahd23,$msakceez24);
			if(!$xxuaqwse26)
			{
				die('Could not connect: '.mysql_error());
			}
			$pwtsnmsr27=mysql_select_db($hjkmiysb6,$xxuaqwse26);
			if(!$pwtsnmsr27)
			{
				die('Can\'t use '.$hjkmiysb6.' : '.mysql_error());
			}
			if(mysql_query("DELETE FROM core_settings"))
			{
				if(mysql_query("INSERT INTO core_settings VALUES('WWW','{$rblyunyw33}'),('SITE_NAME','{$hzyhesrf34}'),('SITE_DESC','{$xyrdzwiw35}'),('SITE_KEYW','{$kuhfybra36}'),('ADMINDIR','{$swotethg37}'),('SITE_EMAIL','{$bdbfrztg38}'),('VERIFY_EMAIL','{$eiggaoxd39}'),('DEMO_MODE','OFF'),('DATABASE_SALT','{$lzsesxfm45}'),('CURRENCY_CODE','{$sacgvbji41}'),('CURRENCYSYMBOL','{$encmyzaa42}'),('PAYPAL_SANDBOX','{$dnucpcim43}'),('PAYPAL_EMAIL','{$pvmzngxw44}'),('OAUTH','{$jqpdpavr52}'),('MAX_INVITES','{$kmtcuwml50}'),('ALLOW_INVITES','{$xchxejwv51}'),('PUSALT','{$btmzfthz48}'),('PAGINATION_PER_PAGE','{$ieypjqkg46}'),('TIMEZONE','{$tbqupicv47}'),('ALLOW_REGISTRATIONS','{$tuizqean40}'),('TOKEN_PRICE','{$dsoyyntn49}'),('ADMIN_LEVEL','{$zfdnwwwp53}'),('THEME_NAME','{$lzuucrpr54}'),('BRUTEFORCE_LIMIT','{$xevfwsny55}'),('BRUTEFORCE_TIMEOUT','{$wgniqsdh56}'),('CAPTCHA','{$fjlgqodu57}'),('CAPTCHA_TYPE','{$bnayxhys58}'),('PP_SERVICE_PURCHASE','{$kijefkbw59}'); "))
			{
				$_SESSION['installer']['fresh']['step']=5;
				$_SESSION['installer']['fresh']['completed'][]=4;
				$_SESSION['installer']['fresh']['core']=array('PUSALT' =>$btmzfthz48,'DATABASE_SALT' =>$lzsesxfm45);
				$_SESSION['installer']['fresh']['message']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Core settings have been successfully added to your database.</div>";
				header("location: install.php?step=5");
			}
			else
			{
				$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>An Error has accrued. ".mysql_error()."</div>";
			}
		}
		else
		{
			$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>An Error has accrued. ".mysql_error()."</div>";
		}
	}
	else
	{
		$smbhfywz18="<div class='alert alert-error'>Please complete all required fields.</div>";
	}
}
else
{
	$bysxohis61=str_replace('install/install.php?step=4','',$_SERVER['REQUEST_URI']);$rblyunyw33="http://".$_SERVER["HTTP_HOST"].$bysxohis61."";$hzyhesrf34=$qxoamrnf1;$xyrdzwiw35="The Description";$kuhfybra36="The,Key,Words";$swotethg37="admin/";$bdbfrztg38=$qxoamrnf1." <server@example.com>";$eiggaoxd39="YES";$tuizqean40="YES";$sacgvbji41="GBP";
	$encmyzaa42="&pound;";
	$dnucpcim43="YES";
	$pvmzngxw44="paypal@example.com";
	$lzsesxfm45=create_salt();
	$ieypjqkg46="20";
	$tbqupicv47="Europe/London";
	$btmzfthz48="YES";
	$kmtcuwml50="10";
	$xchxejwv51="YES";
	$jqpdpavr52="OFF";
	$zfdnwwwp53="293847";
	$dsoyyntn49="0.1";
	$lzuucrpr54="mds_light";
	$xevfwsny55="5";
	$wgniqsdh56="15";
	$fjlgqodu57="OFF";
	$bnayxhys58="0";
	$kijefkbw59="NO";
}
}
else if($npoxzxyj19==5)
{
	$pzdinolm0="install.php?step=5";
	if(isset($_POST['submit']))
	{
		$zmdlospx62=$_POST['first_name'];
		$wkutwzgr63=$_POST['last_name'];
		$vskddraw64=$_POST['username'];
		$dqubhily65=$_POST['email'];
		$zypsvswc11=$_POST['password'];
		$kfenqdxu66=$_POST['repeat_password'];
		if($zmdlospx62!="" &&$wkutwzgr63!="" &&$vskddraw64!="" &&$dqubhily65!="" &&$zypsvswc11!="" &&$kfenqdxu66!="")
		{
			if($zypsvswc11==$kfenqdxu66)
			{
				$khanyzot22=$_SESSION['installer']['fresh']['database']['host'];$rrcqkahd23=$_SESSION['installer']['fresh']['database']['user'];$msakceez24=$_SESSION['installer']['fresh']['database']['pass'];$hjkmiysb6=$_SESSION['installer']['fresh']['database']['database'];$xxuaqwse26=mysql_connect($khanyzot22,$rrcqkahd23,$msakceez24);
				if(!$xxuaqwse26)
				{
					die('Could not connect: '.mysql_error());
				}
				$pwtsnmsr27=mysql_select_db($hjkmiysb6,$xxuaqwse26);
				if(!$pwtsnmsr27)
				{
					die('Can\'t use '.$hjkmiysb6.' : '.mysql_error());
				}
				$xzphrsoy60=generate_id();
				$mqdcsptq12=create_salt();
				if($_SESSION['installer']['fresh']['core']['PUSALT']=="YES")
				{
					$mrgbpjuj67=encrypt_password($zypsvswc11,$mqdcsptq12);
				}
				else
				{
					$mrgbpjuj67=encrypt_password($zypsvswc11);
				}
				if(mysql_query("INSERT INTO `users` (`id`, `user_id`, `first_name`, `last_name`, `gender`, `username`, `password`, `email`, `user_level`, `primary_group`, `activated`, `suspended`, `date_created`, `last_login`, `account_lock`, `signup_ip`, `last_ip`, `country`, `whitelist`, `ip_whitelist`, `tokens`, `bank_tokens`, `invited_by`, `salt`, `oauth_provider`, `oauth_uid`, `login_count`) VALUES
	('', $xzphrsoy60, '{$zmdlospx62}', '{$wkutwzgr63}', 'Male', '{$vskddraw64}', '{$mrgbpjuj67}', '{$dqubhily65}', '293847', '293847', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', 'SERVER', 'SERVER', 'United Kingdom', '0', '', 0, 0, '', '{$mqdcsptq12}', 1, '', 0); "))
	{
		$_SESSION['installer']['fresh']['step']=6;$_SESSION['installer']['fresh']['completed'][]=5;$_SESSION['installer']['fresh']['message']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Your admin account has been successfully created.</div>";header("location: install.php?step=6");
	}
	else
	{
		$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>An Error has accrued. ".mysql_error()."</div>";
	}
}
else
{
	$smbhfywz18="<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Passwords don't match.</div>";
}
}
else
{
	$smbhfywz18="<div class='alert alert-error'>Please complete all required fields.</div>";
}
}
else
{
	$zmdlospx62="";
	$wkutwzgr63="";
	$vskddraw64="";
	$dqubhily65="";
	$zypsvswc11="";
	$kfenqdxu66="";
}
}
?>
<!DOCTYPE html><html lang="en"> <head> <meta charset="utf-8"> <title>Shared on www.Ariyan.org | By Somi | MDS Installer - <?php echo $qxoamrnf1;?></title> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <meta name="author" content="MasDyn Studio"> <!-- The styles --> <link href="css/bootstrap.css" rel="stylesheet"> <link href="css/bootstrap-responsive.css" rel="stylesheet"> <link href="css/custom.css" rel="stylesheet"> <style> body{ margin-top: 5%; } </style> <!-- The HTML5 shim, for IE6-8 support of HTML5 elements --> <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]--> <!-- the fav and touch icons --> <link rel="shortcut icon" href="ico/favicon.ico"> <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png"> <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png"> <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png"> <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png"> <script src="js/jquery.js"></script> <script src="js/custom.js"></script> </head> <body> <div class="container"><div class="hero-unit"> <h1>MDS Installer - Install <?php echo $qxoamrnf1;?> <span class="script_version">v<?php echo $ferodmcy2;?></span></h1> <hr /> <div class="row-fluid"> <div class="span3 nav_container"> <ul class="nav nav-tabs nav-stacked"> <li<?php if($npoxzxyj19==1){echo ' class="active"';}?>><a href="install.php?step=1">Versions &amp; Permissions<?php if(in_array(1,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> <li<?php if($npoxzxyj19==2){echo ' class="active"';}?>><a href="install.php?step=2">Database Connection<?php if(in_array(2,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> <li<?php if($npoxzxyj19==3){echo ' class="active"';}?>><a href="install.php?step=3">Install Tables<?php if(in_array(3,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> <li<?php if($npoxzxyj19==4){echo ' class="active"';}?>><a href="install.php?step=4">Site Settings<?php if(in_array(4,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> <li<?php if($npoxzxyj19==5){echo ' class="active"';}?>><a href="install.php?step=4">Admin Account<?php if(in_array(5,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> <li<?php if($npoxzxyj19==6){echo ' class="active"';}?>><a href="install.php?step=5">Installation Complete<?php if(in_array(6,$_SESSION['installer']['fresh']['completed'])){echo '<img src="img/tick.png" height="20px" style="margin: -5px 0px 0px 5px;">';}?></a></li> </ul> </div> <div class="span9 content"> <div id="message"><?php echo $smbhfywz18;?></div> <?php if($npoxzxyj19==1){?> <form action="<?php echo $pzdinolm0;?>" method="POST"> <div class="row-fluid"> <div class="span12"> <strong>PHP Version: </strong> <?php echo phpversion();if(phpversion()>=5){if($uwcsafuf21!==false){$uwcsafuf21=true;}echo " <span style='color:#008605;'>OK!</span>";}else{echo " <span style='color:#C90909;'>Not OK!</span>";$uwcsafuf21=false;}?> </div> </div> <div class="row-fluid"> <div class="span12"> <strong>MySQL Version: </strong>  </div> </div> <div class="row-fluid"> <div class="span12"> <strong>Configuration File: </strong> Config.php <?php if(is_writable("../includes/configuration/config.php")){if($uwcsafuf21!==false){$uwcsafuf21=true;}echo " <span style='color:#008605;'>Writable!</span>";}else{echo " <span style='color:#C90909;'>Not Writable!</span> - Please change the file permissions of 'includes/configuration/config.php' to 0777";$uwcsafuf21=false;}?> </div> </div> <div class="form-actions" style="text-align: center;"> <input class="btn btn-success" type="submit" name="submit" <?php echo($uwcsafuf21===false)?'disabled="disabled"':"";?> value="Start Installation" /> </div> </form> <?php }else if($npoxzxyj19==2){?> <form action="<?php echo $pzdinolm0;?>" method="POST"> <div class="row-fluid"> <div class="span3"> <label>Host<em class="req">*</em></label> <input type="text" name="host" class="span12" value="<?php echo htmlentities($khanyzot22);?>" /> </div> <div class="span3"> <label>Username<em class="req">*</em></label> <input type="text" name="user" class="span12" value="<?php echo htmlentities($rrcqkahd23);?>" /> </div> <div class="span3"> <label>Password</label> <input type="password" name="pass" class="span12" value="<?php echo htmlentities($msakceez24);?>" /> </div> <div class="span3"> <label>Database Name<em class="req">*</em></label> <input type="text" name="database" class="span12" value="<?php echo htmlentities($hjkmiysb6);?>" /> </div> </div> <div class="form-actions" style="text-align: center;"> <a href="install.php?step=1" class="btn btn-primary">Back</a> <input class="btn btn-success" type="submit" name="submit" value="Connect to Database" /> </div> </form> <?php }else if($npoxzxyj19==3){?> <form action="<?php echo $pzdinolm0;?>" method="POST"> <div class="row-fluid"> <div class="span12"> Clicking the <strong>"Install Data"</strong> button <strong>WILL</strong> delete all of the data inside of <strong><?php echo $_SESSION['installer']['fresh']['database']['database'];?></strong> before adding all of our tables and data. Please make sure that your database is empty or is not being used by any other applications. <br /><br />Before installing any data, please make sure you have selected the correct database. </div> </div> <div class="form-actions" style="text-align: center;"> <a href="install.php?step=2" class="btn btn-primary">Back</a> <input class="btn btn-success" type="submit" name="submit" value="Install Data" /> </div> </form> <?php }else if($npoxzxyj19==4){?> <form action="<?php echo $pzdinolm0;?>" method="POST"> <div class="row-fluid"> <div class="span6"> <label>Site Domain<em class="req">*</em></label> <input type="text" name="WWW" class="span12" required="required" value="<?php echo htmlentities($rblyunyw33);?>" /> </div> <div class="span6"> <label>Site Name<em class="req">*</em></label> <input type="text" name="SITE_NAME" class="span12" required="required" value="<?php echo htmlentities($hzyhesrf34);?>" /> </div> </div> <div class="row-fluid"> <div class="span6"> <label>Site Description</label> <textarea name="SITE_DESC" class="span12" required="required" rows="3"><?php echo htmlentities($xyrdzwiw35);?></textarea> </div> <div class="span6"> <label>Site Keywords</label> <textarea name="SITE_KEYW" class="span12" required="required" rows="3"><?php echo htmlentities($kuhfybra36);?></textarea> </div> </div> <div class="row-fluid"> <div class="span3"> <label>Admin Directory<em class="req">*</em></label> <input type="text" name="ADMINDIR" class="span12" required="required" value="<?php echo htmlentities($swotethg37);?>" /> </div> <div class="span3"> <label>Site Email<em class="req">*</em></label> <input type="text" name="SITE_EMAIL" class="span12" required="required" value="<?php echo htmlentities($bdbfrztg38);?>" /> </div> <div class="span2"> <label>Verify Email<em class="req">*</em></label> <select name="VERIFY_EMAIL" class="span12" required="required" value="<?php echo $eiggaoxd39?>"> <option value="YES" <?php if($eiggaoxd39=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($eiggaoxd39=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> <div class="span2"> <label>Allow Registrations<em class="req">*</em></label> <select name="ALLOW_REGISTRATIONS" class="span12" required="required" value="<?php echo $tuizqean40?>"> <option value="YES" <?php if($tuizqean40=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($tuizqean40=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> <div class="span2"> <label>Allow Invites<em class="req">*</em></label> <select name="ALLOW_INVITES" class="span12" required="required" value="<?php echo $xchxejwv51?>"> <option value="YES" <?php if($xchxejwv51=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($xchxejwv51=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> </div> <div class="row-fluid"> <div class="span2"> <label>Max Active Invites<em class="req">*</em></label> <input type="text" name="MAX_INVITES" class="span12" required="required" value="<?php echo htmlentities($kmtcuwml50);?>" /> </div> <div class="span2"> <label>Token Price<em class="req">*</em></label> <input type="text" name="TOKEN_PRICE" class="span12" required="required" value="<?php echo htmlentities($dsoyyntn49);?>" /> </div> <div class="span2"> <label>Currency Code<em class="req">*</em></label> <input type="text" name="CURRENCY_CODE" class="span12" required="required" value="<?php echo htmlentities($sacgvbji41);?>" /> </div> <div class="span2"> <label>Currency Symbol<em class="req">*</em></label> <input type="text" name="CURRENCYSYMBOL" class="span12" required="required" value="<?php echo htmlentities($encmyzaa42);?>" /> </div> <div class="span2"> <label>PayPal Sandbox<em class="req">*</em></label> <select name="PAYPAL_SANDBOX" class="span12" required="required" value="<?php echo $dnucpcim43?>"> <option value="YES" <?php if($dnucpcim43=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($dnucpcim43=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> <div class="span2"> <label>PayPal Purchase<em class="req">*</em></label> <select name="PP_SERVICE_PURCHASE" class="span12" required="required" value="<?php echo $kijefkbw59?>"> <option value="YES" <?php if($kijefkbw59=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($kijefkbw59=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> </div> <div class="row-fluid"> <div class="span4"> <label>PayPal Email<em class="req">*</em></label> <input type="text" name="PAYPAL_EMAIL" class="span12" required="required" value="<?php echo htmlentities($pvmzngxw44);?>" /> </div> <div class="span4"> <label>Database Salt<em class="req">*</em></label> <input type="text" name="DATABASE_SALT" class="span12" required="required" value="<?php echo htmlentities($lzsesxfm45);?>" /> </div> <div class="span4"> <label>Timezone<em class="req">*</em></label> <select name="TIMEZONE" class="span12" required="required" value="<?php echo $tbqupicv47?>"> <?php foreach($dvceaqik32 as $zoshnbpx69=>$rakehieb5){if($rakehieb5==$tbqupicv47){$cvllfqdx70=' selected="selected"';}else{$cvllfqdx70='';}echo '<option value="'.$rakehieb5.'" '.$cvllfqdx70.' >'.$zoshnbpx69.'</option>';}?> </select> </div> </div> <div class="row-fluid"> <div class="span2"> <label>Pagination<em class="req">*</em></label> <input type="text" name="PAGINATION_PER_PAGE" class="span12" required="required" value="<?php echo htmlentities($ieypjqkg46);?>" /> </div> <div class="span2"> <label>Personal User Salt<em class="req">*</em></label> <select name="PUSALT" class="span12" required="required" value="<?php echo $btmzfthz48?>"> <option value="YES" <?php if($btmzfthz48=='YES'){echo 'selected="selected"';}else{echo '';}?>>Yes</option> <option value="NO" <?php if($btmzfthz48=='NO'){echo 'selected="selected"';}else{echo '';}?>>No</option> </select> </div> <div class="span2"> <label>OAuth<em class="req">*</em></label> <select name="OAUTH" class="span12" required="required" value="<?php echo $jqpdpavr52?>"> <option value="ON" <?php if($jqpdpavr52=='ON'){echo 'selected="selected"';}else{echo '';}?>>On</option> <option value="OFF" <?php if($jqpdpavr52=='OFF'){echo 'selected="selected"';}else{echo '';}?>>Off</option> </select> </div> <div class="span2"> <label>Admin Level<em class="req">*</em></label> <input type="text" name="ADMIN_LEVEL" class="span12" required="required" value="<?php echo htmlentities($zfdnwwwp53);?>" /> </div> <div class="span2"> <label>Theme Name<em class="req">*</em></label> <input type="text" name="THEME_NAME" class="span12" required="required" value="<?php echo htmlentities($lzuucrpr54);?>" /> </div> <div class="span2"> <label>Max Failed Logins<em class="req">*</em></label> <input type="text" name="BRUTEFORCE_LIMIT" class="span12" required="required" value="<?php echo htmlentities($xevfwsny55);?>" /> </div> </div> <div class="row-fluid"> <div class="span3"> <label>Login Timeout (Minutes)<em class="req">*</em></label> <input type="text" name="BRUTEFORCE_TIMEOUT" class="span12" required="required" value="<?php echo htmlentities($wgniqsdh56);?>" /> </div> <div class="span2"> <label>Captcha<em class="req">*</em></label> <select name="CAPTCHA" class="span12" required="required" value="<?php echo $fjlgqodu57?>"> <option value="ON" <?php if($fjlgqodu57=='ON'){echo 'selected="selected"';}else{echo '';}?>>On</option> <option value="OFF" <?php if($fjlgqodu57=='OFF'){echo 'selected="selected"';}else{echo '';}?>>Off</option> </select> </div> <div class="span2"> <label>Captcha Type</label> <select name="CAPTCHA_TYPE" class="span12" required="required" value="<?php echo $bnayxhys58?>"> <option value="0" <?php if($bnayxhys58=='0'){echo 'selected="selected"';}else{echo '';}?>>Standard</option> <option value="1" <?php if($bnayxhys58=='1'){echo 'selected="selected"';}else{echo '';}?><?php if(phpversion()<5.3){echo ' disabled="disabled"';}?>>Visual <?php if(phpversion()<5.3){echo '(requires PHP v5.3 or above)';}?></option> <option value="2" <?php if(RECAPTCHA_PUBLIC ==''){echo 'selected="selected"';}else{echo '';}?><?php if(RECAPTCHA_PUBLIC ==''){echo ' disabled="disabled"';}?>>reCaptcha <?php if(RECAPTCHA_PUBLIC ==''){echo '(please enter your reCaptcha access codes)';}?></option> </select> </div> </div> <div class="form-actions" style="text-align: center;"> <a href="install.php?step=3" class="btn btn-primary">Back</a> <input class="btn btn-success" type="submit" name="submit" value="Set Core Settings" /> </div> </form> <?php }else if($npoxzxyj19==5){?> <form action="<?php echo $pzdinolm0;?>" method="POST"> <div class="row-fluid"> <div class="span4"> <label>First Name<em class="req">*</em></label> <input type="text" name="first_name" class="span12" value="<?php echo htmlentities($zmdlospx62);?>" /> </div> <div class="span4"> <label>Last Name<em class="req">*</em></label> <input type="text" name="last_name" class="span12" value="<?php echo htmlentities($wkutwzgr63);?>" /> </div> <div class="span4"> <label>Email Address<em class="req">*</em></label> <input type="text" name="email" class="span12" value="<?php echo htmlentities($dqubhily65);?>" /> </div> </div> <div class="row-fluid"> <div class="span4"> <label>Username<em class="req">*</em></label> <input type="text" name="username" class="span12" value="<?php echo htmlentities($vskddraw64);?>" /> </div> <div class="span4"> <label>Password<em class="req">*</em></label> <input type="password" name="password" class="span12" value="<?php echo htmlentities($zypsvswc11);?>" /> </div> <div class="span4"> <label>Repeat Password<em class="req">*</em></label> <input type="password" name="repeat_password" class="span12" value="<?php echo htmlentities($kfenqdxu66);?>" /> </div> </div> <div class="form-actions" style="text-align: center;"> <a href="install.php?step=4" class="btn btn-primary">Back</a> <input class="btn btn-success" type="submit" name="submit" value="Add Account" /> </div> </form> <?php }else if($npoxzxyj19==6){unset($_SESSION['installer']['fresh']);$_SESSION['installer']['fresh']['step']=1;$_SESSION['installer']['fresh']['completed']=array();?> <div class="row-fluid center"> <div class="span12"> <label><?php echo $qxoamrnf1;?> has been successfully installed. If you have any questions please feel free to <a href="http://www.masdyn.com/support/">Contact Us</a>.</label> </div> </div> <div class="row-fluid center"> <div class="span12"> <label>Please delete the "install" directory before continuing.</label> </div> </div> <div class="form-actions" style="text-align: center;"> <a href="../index.php" class="btn btn-primary">Visit Site</a> </div> <?php }?> 
</div> 
</div> 
</div>
 <footer> <p style="float:left;">&copy; <?php echo date("Y");?> MasDyn Studio - <a href="http://www.masdyn.com/">MasDyn.com</a></p> <span style="text-align:right;float:right;font-size:12px">Installer Version: <?php echo $avviftbo3;?></span> 
</footer>
 </div> <!-- /container --> <script src="js/bootstrap.min.js"></script>
 </body>
</html>