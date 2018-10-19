<?php 
    $tabel="erp_descrieri";
    
    $fields=array(
        'site'=>"Site",
        'id_site'=>"Id site",
//        'id_review'=>"",
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
            'textareaheight'=>200,
            'richText'=>true            
        ),
        'descmod'=>"DescMOD",
        'descdata'=>array(
            'name'=>'Data',
            'type'=>'formatDateTime',
            'format'=>"d/m/Y",
            'inputFormat'=>'YYYY-mm-DD'
            
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
        'codcat'=>array(
            "name"=>"Categorie",
            "noShow"=>1,
        ),
        'pret'=>array(
            "name"=>"Pret",
            "noShow"=>1,
        ),
        'pretK'=>array(
            "name"=>"PretK",
            'type'=>'formatNumber',
            'decimals'=>3,
            'decSep'=>',',
            'thoSep'=>' ',
            "noShow"=>1,
        ),
        'pretV'=>array(
            "name"=>"PretV",
            'type'=>'formatNumber',            
            "noShow"=>1,
        ),
        'pretM'=>array(
            "name"=>"PretM",
            'type'=>'formatNumber',            
            "noShow"=>1,
        ),
        'pretE'=>array(
            "name"=>"PretE",
            'type'=>'formatNumber',            
            "noShow"=>1,
        ),
        'url'=>array(
            "name"=>"URL",
            "noShow"=>1,
        ),
        'rate_score'=>array(
            "name"=>"RateScore",
            "noShow"=>1,
        ),
        'rate_count'=>array(
            "name"=>"RateVotes",
            "noShow"=>1,
        ),
        'sitelink'=>array(
            "name"=>"Site Link",
            "noShow"=>1,
        ),
        'lastprice'=>array(
            "name"=>"Last price",
            "noShow"=>1,
        ),
        'pretreal'=>array(
            "name"=>"Pret Real",
            "noShow"=>1,
        ),
        'lunistoc'=>array(
            "name"=>"Luni in stoc",
            "noShow"=>1,
        ),
        'discount'=>array(
            "name"=>"Discount",
            "noShow"=>1,
        ),
        'valid'=>array(
            "name"=>"Valid",
            "noShow"=>1,
        ),
        'pret_site'=>array(
            "name"=>"Pret pe site",
            "noShow"=>1,
        ),
        'on_site'=>array(
            "name"=>"Pe site",
            "noShow"=>1,
        ),
        'sale_price'=>array(
            "name"=>"Pret vanzare",
            "noShow"=>1,
        ),
    );
    
    $title="Descrieri";

    $specials=array('drepturi','drepturi2');

    $stitles=array(
	'drepturi'=>'Drepturi'
    );

    $fontawesome=array(
	'drepturi'=>'eye'
    );
    $items_per_page=10;
?>