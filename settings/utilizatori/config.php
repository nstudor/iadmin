<?php 
$tabel="login_users";
$fields=array(
	'nume'=>"Numele si prenumele",
	'user'=>"Utilizator",
	'email'=>'E-mail',
	'role'=>"Rol",
);


$addfields=array(
	'user'=>"Utilizator",
	'role'=>"Rol",
	'nume'=>"Numele si prenumele",
	'sex'=>"Sex",
	'telefon'=>"Telefon",
	'mobil'=>"Telefon mobil",
	'fax'=>"Fax",
	'email'=>'E-mail',
	'yahooid'=>'Yahoo ID',
	'functie'=>'Functie',
	'cnp'=>"C.N.P.",
	'ci'=>"C. I.",
	'detalii'=>"Detalii",
);

$order="";
$title="Utilizatori";
$loadmce='yes';

$specials=array('key', 'face');
$stitles=array(
	'key'=>'Parola',
	'face'=>'Tema grafica'
);


$confdroptext='Stergi utilizatorul';
$confdropfield='user';
?>