<?php 
    $items_per_page=25;
    if($dontshowpages) { $st=0; $items_per_page=1000000000; }
    
    if (!isset($id)) $id='id';
    
    if (isset($_POST['order'])) {
        unset($_SESSION['order'][$_POST['order']]);
       if(strlen($_POST['ordertype'])==2) $_SESSION['order'][$_POST['order']]=$_POST['ordertype'];    
    }
    if (isset($param[1])) $st=$param[1]; else $st=$_SESSION['st']*1;
    
    $pag=$param[0];

    if( file_exists($settingFile) )
    {
        foreach($fields as $k=>$v) if(is_array($v)) if($v['noShow']) unset($fields[$k]);        
        if($pag!=$_SESSION['page'])
        {
            unset($_SESSION['filter']);
            unset($_SESSION['defaults']);
            unset($_SESSION['order']);
            $_SESSION['page']=$pag;
            $st=0;
        }
        
if(($_POST['multi']=='yes')&&(count($_POST['d'])>0))
		{
		foreach($_POST as $k=>$v) if(substr($k,0,4)=='oper') $oper=substr($k,5);
		$d=implode(",",$_POST['d']);?>
        <script type="text/javascript">
window.onload = function() {
	Shadowbox.open({
        content:    'modal.php?p=<?php echo $param[0].'-'.$param[1] ?>-multi<?php echo $oper ?>&id=<?php echo $d ?>',
        player:     "iframe",
        title:      "Multi-Actiune",
        height:     <?php echo (isset($operheight[$oper])?$operheight[$oper]:150) ?>,
        width:      <?php echo (isset($operwidth[$oper])?$operwidth[$oper]:450) ?>
    });
}
</script>
<?php }
        $_SESSION['st']=$st;
	if(count($_SESSION['order'])!=0)
	{
            $order='';
            foreach($_SESSION['order'] as $k=>$v) $order="$k ".str_replace(array('up','dn'), array('ASC', 'DESC'),$v).", $order";
            $order="$order $id";
	}
        if(isset($defaultOrder)) $order=$defaultOrder;
        $flt="1";	
        if(isset($param[2]))
            if($param[3]=='filtru')
                $flt=$param[4]."='".$param[5]."'";

        if(isset($_POST['fld']))
            if($_POST['fv']!=5)
            {
                    $_SESSION['filter'][$_POST['fld']]=$_POST[$_POST['fld']];
                    $_SESSION['filtertype'][$_POST['fld']]=$_POST['fv'];		
            } else unset($_SESSION['filter'][$_POST['fld']], $_SESSION['filtertype'][$_POST['fld']]);
	if($_POST['fv']==999) unset($_SESSION['filter'],$_SESSION['filtertype']); // clear all filters
        if(is_array($_SESSION['filter']))
            foreach($_SESSION['filter'] as $k=>$v)
                switch($_SESSION['filtertype'][$k])
                {
                    case 1:$flt.=" AND `$k` LIKE '%$v%'";break;
                    case 2:$flt.=" AND `$k` NOT LIKE '%$v%'";break;
                    case 3:$flt.=" AND `$k`='$v'";break;
                    case 4:$flt.=" AND `$k`!='$v'";break;
                    case 6:$flt.=" AND `$k` IN ('".implode("','",$v)."')";break;
                    case 8:
                        $fa=explode("~",$v);
                        $flt.=" AND `$k`>='$fa[0]' AND $k<='$fa[1]'";
                        echo $flt;
                    break;
                    case 9:$flt.=" AND `$k` LIKE '$v'";break;
                    case 11:$flt.=" AND `$k`>'$v'";break;
                    case 12:$flt.=" AND `$k`<'$v'";break;
                    case 13:$flt.=" AND `$k`>='$v'";break;
                    case 14:$flt.=" AND `$k`<='$v'";break;
                }
        $filtersExists=0;
        foreach($fields as $k=>$v) if(isset($_SESSION['filter'][$k])) $filtersExists++;
        $rn=db_select('count(*) nr', $tabel, $flt)[0];    
        $np=($rn==0?0:floor(($rn['nr']-1)/$items_per_page));
        if($st>$np) $st=$np;    
        if($st<0) $st=0;    
//        echo $flt;
        
        $rows=db_select('*', $tabel, $flt, $order, ($st*$items_per_page).', '.$items_per_page);
        if ( (count($rows) == 0) && empty($MESSAGE) ) $MESSAGE = 'No records to show !';
        $nr=0;
    } else {
        $MESSAGE='Config file missing';
    }