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
	'telefon'=>array(
            "name"=>"Telefon",
            "noShow"=>1,
        ),
	'mobil'=>array(
            "name"=>"Telefon mobil",
            "noShow"=>1,
        ),
	'fax'=>array(
            "name"=>"Fax",
            "noShow"=>1,
        ),
	'yahooid'=>array(
            "name"=>'Yahoo ID',
            "noShow"=>1,
        ),
	'functie'=>array(
            "name"=>'Functie',
            "noShow"=>1,
        ),
	'cnp'=>array(
            "name"=>"C.N.P.",
            "noShow"=>1,
        ),
	'ci'=>array(
            "name"=>"C. I.",
            "noShow"=>1,
        ),
	'details'=>array(
            "name"=>"Detalii",
            "noShow"=>1,
        ),
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