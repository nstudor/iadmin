<?php
session_start();
//	include("defines.php");
//	mysql_query("UPDATE login_users SET chattime=now() WHERE id=".$_SESSION['userid']);
echo strftime("%a, %d %b %Y, %H<sup>%M</sup>");
