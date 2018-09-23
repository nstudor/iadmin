<?php 
    $tabel="erp_descrieri";
    
    $fields=array(
        'site'=>"Site",
        'id_site'=>"Id site",
        'id_review'=>"",
        'activ'=>array(
            'name'=>"Activ",
            'type'=>'awesomecase',
            'values'=>array(1,0),
            'chars'=>array('check','times'),
            'colors'=>array('#94C11E','#D40000'),
        ),
        'public'=>array(
            'name'=>"Public",
            'type'=>'awesomecase',
            'template'=>'YesNoCheck',
        ),
        'ecode'=>"ECODE",
        'denumire'=>"Denumire",
        'descriere1'=>array(
            'name'=>"Descriere1",
            'type'=>'byteslength',
            'mesaureUnit'=>'b',
            'unitSize'=>1024,
            'maxDepth'=>0,
        ),
        'descriere2'=>array(
            'name'=>"Descriere2",
            'type'=>'byteslength',
            'mesaureUnit'=>'b',
            'unitSize'=>1024,
            'maxDepth'=>1,
            'prefix'=>'Size: ',
            'suffix'=>' total'
        ),
        'descriereok'=>array(
            'name'=>"DescriereOK",
            'type'=>'byteslength',
            'mesaureUnit'=>'b',
            'unitSize'=>1024,
            'maxDepth'=>2,
            'prefix'=>'<i class="fas fa-bars"></i> ',
        ),
        'descmod'=>"DescMOD",
        'descdata'=>array(
            'name'=>'Data',
            'type'=>'formatDateTime',
            'format'=>"d/m/Y",
            
        ),
        'userid'=>"UserID",
        'codfurn'=>array(
            'name'=>'Furnizor',
            'type'=>'dbSelect',
            'defaultValue'=>0,
            'defaultResult'=>'Not set',
            'field'=>'denumire',
            'table'=>'erp_brand',
            'relatedField'=>'cod',
        ),
        'codcat'=>"Categorie",
        'pret'=>"Pret",
        'pretK'=>array(
            "name"=>"PretK",
            'type'=>'formatNumber',
            'decimals'=>3,
            'decSep'=>',',
            'thoSep'=>' ',
        ),
        'pretV'=>array(
            "name"=>"PretV",
            'type'=>'formatNumber',            
        ),
        'pretM'=>array(
            "name"=>"PretM",
            'type'=>'formatNumber',            
        ),
        'pretE'=>array(
            "name"=>"PretE",
            'type'=>'formatNumber',            
        ),
        'url'=>"URL",
        'rate_score'=>"RateScore",
        'rate_count'=>"RateVotes",
        'sitelink'=>"Site Link",
        'lastprice'=>"Last price",
        'pretreal'=>"Pret Real",
        'lunistoc'=>"Luni in stoc",
        'discount'=>"Discount",
        'valid'=>"Valid",
        'pret_site'=>"Pret pe site",
        'on_site'=>"Pe site",
        'sale_price'=>"Pret vanzare",
    );
    
    $addfields=array(
    );
    
    $title="Descrieri";

    $specials=array('drepturi','drepturi2');

    $stitles=array(
	'drepturi'=>'Drepturi'
    );

    $fontawesome=array(
	'drepturi'=>'eye'
    );

?>