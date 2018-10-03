<?php 
$tabel="login_users";
$fields=array(
	'nume'=>"Numele si prenumele",
	'user'=>"Utilizator",
	'email'=>'E-mail',
	'role'=>array(
            "name"=>"Rol",
            'type'=>'dbSelect',
            'defaultValue'=>0,
            'defaultResult'=>'Not set',
            'field'=>'rolename',
            'table'=>'login_roles',
            'relatedField'=>'id',
        ),
	'sex'=>array(
            "name"=>"Sex",
            'values'=>'M,F,X',
            'chars'=>'mars fa-2x,venus fa-2x,transgender fa-2x',
            'type'=>'awesomecase',
        ),
    );


$addfields=array(
	'user'=>"Utilizator",
	'role'=>array(
            "name"=>"Rol",
            'type'=>'dbSelect',
            'defaultValue'=>0,
            'defaultResult'=>'Not set',
            'field'=>'rolename',
            'table'=>'login_roles',
            'relatedField'=>'id',
        ),
	'nume'=>"Numele si prenumele",
	'sex'=>array(
            "name"=>"Sex",
            'values'=>'M,F,X',
            'chars'=>'mars,venus',
            'type'=>'awesomecase',
        ),
	'telefon'=>"Telefon",
	'mobil'=>"Telefon mobil",
	'fax'=>"Fax",
	'email'=>'E-mail',
	'yahooid'=>'Yahoo ID',
	'functie'=>'Functie',
	'cnp'=>"C.N.P.",
	'ci'=>"C. I.",
	'details'=>"Detalii",
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