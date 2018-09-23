<?php 
$tabel="login_dashboard";
$fields=array( 
  'denumire'=>"Denumire",
  'fisier'=>"Addon",
  'rand'=>"Rand",
  'marimesm'=>"Marime<br />Mobil",
  'marimelg'=>"Marime<br />Desktop",
  'ordine'=>"Ordine",
  'deschis'=>"Deschis",
  'vizibil'=>"Vizibil",
);

$addfields=array(
  'denumire'=>"Denumire",
  'fisier'=>"Addon",
  'rand'=>"Rand",
  'marimesm'=>"Marime Mobil",
  'marimelg'=>"Marime Desktop",
  'ordine'=>"Ordine",
  'deschis'=>"Deschis",
  'vizibil'=>"Vizibil",
);

$title="Dashboard";

$_SESSION['filter']['id_user']=$_SESSION['userid'];
$_SESSION['filtertype']['id_user']=1;

$defaults=array( 'id_user'=>$_SESSION['userid'] );

?>