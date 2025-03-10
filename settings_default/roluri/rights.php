<?php 
    if(isset($_POST['ch']['v'])) {
        $u['v']=implode(' ', array_slice($_POST['ch']['v'],1));
        $u['a']=implode(' ', array_slice($_POST['ch']['a'],1));
        $u['m']=implode(' ', array_slice($_POST['ch']['m'],1));
        $u['d']=implode(' ', array_slice($_POST['ch']['d'],1));
        db_update(
            [
                'details_v'=>$u["v"],
                'details_a'=>$u["a"],
                'details_m'=>$u["m"], 
                'details_d'=>$u["d"]
            ], 'login_rights', "id_role=$get[id] AND id_menu=$_POST[id]");
    }
    $rr= db_select('*', 'login_menu', 'id!=0', 'ordine');
        
    function afiseaza($rr, $level, $spc, $role) {
        foreach($rr as $r)
            if($r['id_tata']==$level) {
                $dr=db_select('*', 'login_rights', "id_menu=$r[id] AND id_role=$role")[0];
    if($r['link']!="") {
        $x=explode('-',$r['link']);
        $specials=array();
        if($x[0]=='tabel') include("settings/$x[1]/config.php");
        $y=count($specials);
        $x=explode(' ',$dr['details_v']);
        $z=count($x);
        if($x[0]=='') $z--;
        $d=1;
    } else { $z=0; $y=0; $d=0; }
?>
<tr>
    <?= str_repeat('<td width="3%">&nbsp;</td>', $spc) ?>        
    <td colspan="<?= 5-$spc ?>"><?= $r['denum']; ?></td>        
<?php if($d!=0) {?>                
    <td id="d_<?php echo $r['id'] ?>_v" class="text-center"><button class="btn btn-<?php echo ($dr['view_right']=='Y'?'success':'danger'); ?>" onclick="butonat(<?php echo $r['id'] ?>,'v')">O</button></td>        
    <td id="d_<?php echo $r['id'] ?>_a" class="text-center"><button class="btn btn-<?php echo ($dr['add_right']=='Y'?'success':'danger'); ?>" onclick="butonat(<?php echo $r['id'] ?>,'a')">O</button></td>        
    <td id="d_<?php echo $r['id'] ?>_m" class="text-center"><button class="btn btn-<?php echo ($dr['modify_right']=='Y'?'success':'danger'); ?>" onclick="butonat(<?php echo $r['id'] ?>,'m')">O</button></td>        
    <td id="d_<?php echo $r['id'] ?>_d" class="text-center"><button class="btn btn-<?php echo ($dr['delete_right']=='Y'?'success':'danger'); ?>" onclick="butonat(<?php echo $r['id'] ?>,'d')">O</button></td>        
<?php if($y!=0) {?>            
    <td class="text-center"><button class="btn btn-info spc" data-toggle="modal" data-target="#myModal" onclick="gomodal('<?php echo $r['id'] ?>', 'Drepturi operatii')"><?php echo "$z / $y"; ?></button></td>        
<?php } else { ?>
    <td>&nbsp;</td>        
<?php }} else { ?>
    <td colspan="5">&nbsp;</td>        
<?php } ?>
</tr>
<?php /*if($r['link']!="") {
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
		<?php
 * 
 */
            afiseaza($rr, $r['id'], $spc+1, $role);
		}
			
	}
	
?>
<div class="container">
<table class="table table-striped table-bordered">
    <thead class="bg-info text-white">
        <th colspan="5">Denumire</th>
        <th>Vizualizare</th>
        <th>Adaugare</th>
        <th>Modificare</th>
        <th>Stergere</th>
        <th>Extra</th>
    </thead>
    <tbody><?php afiseaza($rr, 0, 1, $get['id']); ?></tbody>
</table>
</div>
<?php        
/*    
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
*/?>
<script type="text/javascript">
    function butonat(i, v) {
        $('#d_'+i+'_'+v).html('<i class="fa fa-spinner fa-pulse"></i>');
	$.ajax({
	  url: "ajax/modal.php?p=../settings_default/roluri/ajaxright&idu=<?php echo $get['id'] ?>&idd="+i+"&tip="+v,
	}).done(function(msg) {
	  $('#d_'+i+'_'+v).html(msg);
	});
    }
    function gomodal(l,t) {
	$('#myModalLabel').html(t);
	$('#myModal .modal-body').html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');
	$.ajax({
	  url: "ajax/modal.php?p=../settings_default/roluri/ajaxdet&idu=<?php echo $get['id'] ?>&idd="+l,
	}).done(function(msg) {
	  $('#myModal .modal-body').html(msg);
	});
    }
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="myModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
