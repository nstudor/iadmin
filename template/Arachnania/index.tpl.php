<?php 
function submeniu($m,$menu) {
?>
                            <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $m['denum'] ?></a>
                              <ul class="dropdown-menu">
<?php foreach($menu as $m1) if($m['id']==$m1['id_tata']) {
if($m1['link']=='') submeniu($m1, $menu); else { ?>
                                <li class="menu-item "><a href="?p=<?php echo $m1['link'] ?>"><?php echo $m1['denum'] ?></a></li>
<?php }} ?>
                              </ul>
                            </li>
						
<?php }
$specials=array();
$_SESSION['link']=$_GET['p'];
$link=explode("-",$_GET['p']);
if(isset($link[3])) $link[2]='0';
	else if(isset($link[2])) unset($link[2]);
$link=implode("-",$link);
mysql_query('SET NAMES utf8');
$ruser=mysql_fetch_array(mysql_query("SELECT * FROM login_users WHERE id=".$_SESSION['userid']));
$rcmenu=@mysql_fetch_array(@mysql_query("SELECT * FROM login_menu WHERE link='$link'"));
$rcr=@mysql_fetch_array(@mysql_query("SELECT * FROM login_rights WHERE id_menu=".$rcmenu['id']." AND id_role=".$ruser['role']));
$rcr['detalii_v']=explode(" ",$rcr['detalii_v']);
$rcr['detalii_a']=explode(" ",$rcr['detalii_a']);
$rcr['detalii_m']=explode(" ",$rcr['detalii_m']);
$rcr['detalii_s']=explode(" ",$rcr['detalii_s']);
$_SESSION['rights']=$rcr;
if(isset($_SESSION['menudata'])) $menu=$_SESSION['menudata']; else {
	$menu=array();
	$re=mysql_query("SELECT * FROM login_menu WHERE id!=0 ORDER BY ordine");
	while($r=mysql_fetch_array($re))
		{
			$menu[$r['id']]=$r;
			$rd=@mysql_fetch_array(@mysql_query("SELECT * FROM login_rights WHERE id_menu=".$r['id']." AND id_role=".$ruser['role']));
			$ok=false;
			if($r['right']=='Y') $ok=true;
			if($rd['vizualizare']=='Y') $ok=true;
			$menu[$r['id']]['ok']=$ok;
		}
	foreach($menu as $m) if((!$menu[$m['id_tata']]['ok'])&&($m['ok'])) $menu[$m['id_tata']]['ok']=true;
	foreach($menu as $m) if((!$menu[$m['id_tata']]['ok'])&&($m['ok'])) $menu[$m['id_tata']]['ok']=true;
	foreach($menu as $k=>$m) if(!$m['ok']) unset($menu[$k]);
	$_SESSION['menudata']=$menu;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $progname ?> - Conectare</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php
 	if($param[0]!='') {
		$pag=$param[1];	
	 	if(file_exists("settings/$pag/config.php")) include("settings/$pag/config.php"); else { echo "</head><body>";include("404.php");die("</body></html>");}
		
		$plugins=array_slice(explode(' ',$plugins),1);
		foreach($plugins as $pl)
			if(file_exists("plugins/$pl.php")) include("plugins/$pl.php");	
	}
?>
</head>
<body>
<nav class="navbar navbar-default">
          <div class="navbar-header">
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="./" class="navbar-brand"><i class="fa fa-home"></i></a>
          </div>
          <div class="navbar-collapse collapse"><a href="./?p=logout" class="logout"><i class="fa fa-big fa-power-off"></i></a>
<?php if($ruser['user']=='stefan') { ?>
	<a href="./?p=tabel-ihelp" class="logout" style="margin-right:20px"><i class="fa fa-big fa-info-circle"></i></a>
<?php } ?>
            <ul class="nav navbar-nav">
<?php
$menu1=$menu;
$menu2=$menu;
$menu3=$menu;
foreach($menu1 as $m1) if(($m1['link']=='')&&($m1['id_tata']==0)&&($m1['id']!='')) { 
$n=0; foreach($menu2 as $m2) if($m2['id_tata']==$m1['id']) $n++; 
if($n==0) {?>
              <li><a href="<?php echo $m1['link'] ?>" ><?php echo $m1['denum'] ?></a></li>
<?php }else { ?>
              <li class="dropdown">
                <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $m1['denum'] ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
<?php foreach($menu2 as $m2) if($m2['id_tata']==$m1['id'])
if($m2['denum']=='-') { ?>
                  <li class="divider" role="separator"></li>
<?php } else {
if($m2['link']=='') submeniu($m2, $menu); else { ?>
                  <li><a href="./?p=<?php echo $m2['link'] ?>"><?php echo $m2['denum'] ?></a></li>
<?php }} ?>
                </ul>
              </li>
<?php }} ?>
				<li></div>
             </ul>
          </div>
      </nav>
<?php
	if($param[0]!='') {
		$id='id';
		$r=mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM `$tabel` WHERE `Key`='PRI'"));
		if($r['Key']=='PRI') $id=$r['Field'];
		if(isset($_GET['id'])) $item=mysql_fetch_array(mysql_query("SELECT * FROM $tabel WHERE $id=".$_GET['id']));
		include($param[0].'.php');
	} else include('first.php'); ?>
<div class="bottom navbar navbar-default">
<div style="float:right; margin-right:10px;" id="clock">0:00</div>
</div>
<script>
$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault(); 
    event.stopPropagation(); 
    $(this).parent().addClass('open');
    var menu = $(this).parent().find("ul");
    var menupos = menu.offset(); 
    if ((menupos.left + menu.width()) + 30 > $(window).width()) {
        var newpos = - menu.width();      
    } else {
        var newpos = $(this).parent().width();
    }
    menu.css({ left:newpos });
});
function clock() {
	$.ajax({
	  url: "ajaxtime.php",
	}).done(function(msg) {
	  $("#clock").html(msg);
	});
}
clock();
setInterval("clock()",15000);
</script>
</body>
</html>