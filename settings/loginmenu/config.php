<?php 
    $tabel="login_menu";
    $fields=array(
        'id'=>"ID",
        'id_tata'=>array(
            'name'=>"Parent",
            'type'=>'dbSelect',
            'field'=>'denum',
            'table'=>'login_menu',
            'relatedField'=>'id',            
            'defaultValue'=>0,
            'defaultResult'=>'[[ MAIN ]]',
        ),
        'denum'=>"Name",
        'link'=>"Link",
        'ordine'=>"Order",
        'right'=>array(
            'name'=>"Right",
            'type'=>'awesomecase',
            'template'=>'YesNoCheck',
        ),        
        'icon'=>"Icon",
    );


    $addfields=array(
        'id_tata'=>"Parent",
        'denum'=>"Name",
        'link'=>"Link",
        'ordine'=>"Order",
        'right'=>"Right",
        'icon'=>"Icon",
    );

    $order="";
    $title="Menu";
	
    $rcr['view_right']='Y';
    $rcr['add_right']='Y';
    $rcr['modify_right']='Y';
    $rcr['delete_right']='Y';
    $rcr['details_v']='';
    $rcr['details_a']='';
    $rcr['details_m']='';
    $rcr['details_d']='';
?>