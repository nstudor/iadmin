<?php 
    $items_per_page=25;
    
    if(!isset($id)) $id='id';
        
    if(isset($param[2])) $st=$param[2]; else $st=$_SESSION['st']*1;
    
    $pag=$param[1];
    
    if( file_exists("settings/$pag/config.php") )
    {
        include("settings/$pag/config.php");       
        if($pag!=$_SESSION['page'])
        {
            unset($_SESSION['filter']);
            unset($_SESSION['defaults']);
            unset($_SESSION['order']);
            $_SESSION['page']=$pag;
            $st=0;
        }

        $flt=1;

        $rn=db_select('count(*) nr', $tabel, $flt)[0];    
        $np=($rn==0?0:floor(($rn['nr']-1)/$items_per_page));
        if($st>$np) $st=$np;    

        $rows=db_select('*', $tabel, $flt, $order, ($st*$items_per_page).', '.$items_per_page);
        if ( (count($rows) == 0) && empty($MESSAGE) ) $MESSAGE = 'No records to show !';
    //    print_r($rcr);
        $nr=0;
    } else {
        $MESSAGE='Config file missing';
    }
    

/*
	if($_POST['multi']=='yes') foreach($_POST as $k=>$v) if(strpos($k,'oper-')!==false) include(str_replace('_','/',str_replace('oper-','multi',"$k.php")));
	
/ *
	Explicatii $param
	0 = "tabel"
	1 = include("settings/ $$$ .php")
	
	$dontshowpages = nu mai arata paginatia (si listeaza toate conform filtrului)
* /
	
	if(isset($_GET['pag'])) $st=$_GET['pag']; else $st=$_SESSION['st'];



	$_SESSION['st']=$st;

	if($_POST['fv']==999) unset($_SESSION['filter'],$_SESSION['filtertype']); // clear all filters
/ * 	if(($_POST['multi']=='yes')&&(count($_POST['d'])>0))
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
<?php } * /

	
	if(isset($param[3]))
		if($param[3]=='filtru')
			unset($fields[$param[4]]);
	if($debug) print_r($_POST);
	
	if(isset($_POST['order']))
		{
		unset($_SESSION['order'][$_POST['order']]);
		$_SESSION['order'][$_POST['order']]=$_POST['ordertype'];
		}
//	foreach($_SESSION as $k=>$v)	unset($_SESSION[$k]);

/ *
	if(!isset($_SESSION['filter']))
		{
			$_SESSION['st']=1;
			$_SESSION['page']=$pag;
			$_SESSION['filter']=array();
			$_SESSION['order']=array();
		}
* /
	if($dontshowpages) { $st=0; $items_per_page=1000; }
	if(count($_SESSION['order'])!=0)
	{
		$order='';
		foreach($_SESSION['order'] as $k=>$v) $order="$k ".str_replace(array('up','dn'), array('ASC', 'DESC'),$v).", $order";
		$order=" ORDER BY $order $id";
	}
if(isset($defaultOrder)) $order=$defaultOrder;
$flt="1";	
if(isset($param[3]))
	if($param[3]=='filtru')
		$flt=$param[4]."='".$param[5]."'";


if(isset($_POST['fld']))
	if($_POST['fv']!=5)
	{
		$_SESSION['filter'][$_POST['fld']]=$_POST[$_POST['fld']];
		$_SESSION['filtertype'][$_POST['fld']]=$_POST['fv'];		
	} else unset($_SESSION['filter'][$_POST['fld']], $_SESSION['filtertype'][$_POST['fld']]);

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
		}


$filtersExists=0;
foreach($fields as $k=>$v) if(isset($_SESSION['filter'][$k])) $filtersExists++;
		

$rn=mysql_fetch_array(mysql_query("SELECT count(*) nr FROM $tabel WHERE $flt")) or die(mysql_error()."<br />SELECT count(*) nr FROM $tabel WHERE $flt");
$np=floor(($rn['nr']-1)/$items_per_page)+1;
if($st>$np) $st=$np;
$st=($st-1)*$items_per_page;
$q="SELECT * FROM $tabel WHERE $flt $order LIMIT $st, $items_per_page";
//echo $q;
$re=mysql_query($q);
$nr=0;
*/
?>
