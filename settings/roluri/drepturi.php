<?php 
	if(isset($_POST['ch']['v'])) {
		$u['v']=implode(' ', array_slice($_POST['ch']['v'],1));
		$u['a']=implode(' ', array_slice($_POST['ch']['a'],1));
		$u['m']=implode(' ', array_slice($_POST['ch']['m'],1));
		$u['s']=implode(' ', array_slice($_POST['ch']['s'],1));
		mysql_query("UPDATE login_rights SET detalii_v='$u[v]', detalii_a='$u[a]', detalii_m='$u[m]', detalii_s='$u[s]' WHERE id_role=$_GET[id] AND id_menu=$_POST[id]");
	}
	function afiseaza($level, $spc) {
		$re=mysql_query("SELECT * FROM login_menu WHERE id_tata=$level AND id!=id_tata ORDER BY ordine");
		while($r=mysql_fetch_assoc($re))
		{
			$dr=mysql_fetch_assoc(mysql_query("SELECT * FROM login_rights WHERE id_menu=$r[id] AND id_role=$_GET[id]"));		
		?>
        <div class="row spc" style="border-top:1px solid #CCC">
			<div class="col-xs-6 col-sm-6 col-lg-6"><?php echo $spc.$r['denum']; ?></div>        
            <?php if($r['link']!="") {
				$x=explode('-',$r['link']);
				$specials=array();
				if($x[0]=='tabel') include("settings/$x[1]/config.php");
				$y=count($specials);
				$x=explode(' ',$dr['detalii_v']);
				$z=count($x);
				if($x[0]=='') $z--;
			?>
			<div class="col-xs-1 col-sm-1 col-lg-1" id="d_<?php echo $r['id'] ?>_v"><button class="btn btn-<?php echo ($dr['vizualizare']=='Y'?'success':'danger'); ?> spc" onclick="butonat(<?php echo $r['id'] ?>,'v')">O</button></div>        
			<div class="col-xs-1 col-sm-1 col-lg-1" id="d_<?php echo $r['id'] ?>_a"><button class="btn btn-<?php echo ($dr['adaugare']=='Y'?'success':'danger'); ?> spc" onclick="butonat(<?php echo $r['id'] ?>,'a')">O</button></div>        
			<div class="col-xs-1 col-sm-1 col-lg-1" id="d_<?php echo $r['id'] ?>_m"><button class="btn btn-<?php echo ($dr['modificare']=='Y'?'success':'danger'); ?> spc" onclick="butonat(<?php echo $r['id'] ?>,'m')">O</button></div>        
			<div class="col-xs-1 col-sm-1 col-lg-1" id="d_<?php echo $r['id'] ?>_s"><button class="btn btn-<?php echo ($dr['stergere']=='Y'?'success':'danger'); ?> spc" onclick="butonat(<?php echo $r['id'] ?>,'s')">O</button></div>        
<?php if($y!=0) {?>            
			<div class="col-xs-2 col-sm-2 col-lg-2"><button class="btn btn-info spc" data-toggle="modal" data-target="#myModal" onclick="gomodal('<?php echo $r['id'] ?>', 'Drepturi operatii')"><?php echo "$z / $y"; ?></button></div>        
<?php } else { ?>
			<div class="col-xs-2 col-sm-2 col-lg-2">&nbsp;</div>        
<?php } ?>
            <?php } else { ?>
			<div class="col-xs-6 col-sm-6 col-lg-6">&nbsp;</div>                    
            <?php } ?>
        </div>
		<?php afiseaza($r['id'],"$spc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		}
			
	}
	afiseaza(0, '');
?>
<script type="text/javascript">


function butonat(i, v) {
	$.ajax({
	  url: "settings/roluri/ajaxright.php?idu=<?php echo $_GET['id'] ?>&idd="+i+"&tip="+v,
	}).done(function(msg) {
	  $('#d_'+i+'_'+v).html(msg);
	});
}

function gomodal(l,t) {
	$('#myModalLabel').html(t);
	$('#myModal .modal-body').html('<h1 style="text-align:center"><i class="fa fa-spinner fa-pulse" style="font-size:108px"></i></h1>');
	$.ajax({
	  url: "settings/roluri/ajaxdet.php?idu=<?php echo $_GET['id'] ?>&idd="+l,
	}).done(function(msg) {
	  $('#myModal .modal-body').html(msg);
	});
}


</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>