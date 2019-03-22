<?php

$dd=strtotime(isset($_GET['data'])?$_GET['data']:"now");
	$an=date("Y",$dd);
	$lu=date("m",$dd);
	$zi=date("d",$dd);
	$crt=(date("Y-m-d",$dd)==date("Y-m-d",strtotime("$an-$lu-".date("j"))));