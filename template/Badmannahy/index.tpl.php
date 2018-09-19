<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $APP_NAME ?></title>
<link rel="icon" type="image/gif" href="favicon.gif" />	
<link rel="stylesheet" href="./css/bootstrap.min.css" />
<script src="./js/jquery.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>    
<link rel="stylesheet" href="./css/all.css" />
<?php
        if(file_exists('template/'.$APP_TEMPLATE.'/'.$param[0].'.head.php')) {
            include('template/'.$APP_TEMPLATE.'/'.$param[0].'.head.php');
        }
?>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light bg-light rounded">
      <a class="navbar-brand" href="#"><i class="fas fa-home"></i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav mr-auto">
<?php
$menu1=$menu;
$menu2=$menu;
$menu3=$menu;
foreach($menu1 as $k1=>$m1) 
if(($m1['link']=='')&&($m1['id_tata']==0)&&($m1['id']!='')) { 
$n=0; foreach($menu2 as $m2) if($m2['id_tata']==$m1['id']) $n++; 
if($n==0) {?>            
          <li class="nav-item">
            <a class="nav-link" href="<?= $m1['link'] ?>"><?= $m1['denum'] ?></a>
          </li>
<?php } else { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown<?= $k1 ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $m1['denum'] ?></a>
            <div class="dropdown-menu" aria-labelledby="dropdown<?= $k1 ?>">
<?php foreach($menu2 as $m2) if($m2['id_tata']==$m1['id'])
if($m2['denum']=='-') { ?>
                <a class="divider" role="separator" href='#'></a>
<?php } else {
if($m2['link']=='') { // TODO:SUB-SUBMENU ?>
                <a class="dropdown-item" href="<?php echo $m2['link'] ?>.htm"><?php echo $m2['denum'] ?></a>
<?php
} else { ?>
                <a class="dropdown-item" href="<?php echo $m2['link'] ?>.htm"><?php echo $m2['denum'] ?></a>
<?php }} ?>
            </div>
          </li>
<?php }}?>            
        </ul>
      </div>
      <a class="navbar-brand" href="logout.htm"><i class="fas fa-power-off"></i></a>
</nav>    
    
<?php /*    
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
<?php } else { ?>
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
 * 
 */?>

<?php
    if(file_exists('template/'.$APP_TEMPLATE.'/'.$param[0].'.tpl.php')) {
        include('template/'.$APP_TEMPLATE.'/'.$param[0].'.tpl.php');
    }
?>

<?php /*
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
*/?>
</body>
</html>