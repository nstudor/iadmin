<div class="col">
<?php
    if(file_exists("settings/$pag/header.php")) 
    {
        include("settings/$pag/header.php"); 
    } else {
        echo "<h5>$title</h5>";
    }
?>    
<table class="table table-striped table-bordered table-sm">
    <thead class="bg-info text-white">
        <tr class="text-center">
            <th>
                <a href="toper-<?php echo $param[1] ?>-add.htm" class="btn btn-default text-white"><i class="fas fa-plus"></i></a>
            </th>
<?php foreach($fields as $f) { ?>
            <th>                
                <?= is_array($f)?$f['name']:$f ?>
            </th>
<?php } ?>            
            <th>
            </th>
        </tr>
        <tr class="text-center bg-secondary">
            <th>
<?php if(($filtersExists!=0)&&($showFilter!='no')) { ?>
<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" name="clearfilters">
    <input type="hidden" name="fv" value="999" />
</form>
<i class="fa fa-filter text-danger" style="cursor:pointer" onclick="document.clearfilters.submit()"></i>
<?php } else { ?>&nbsp;<?php } ?>                
            </th>
<?php foreach($fields as $k=>$f) { ?>
            <th>
<form action="" method="post" id="ord_<?php echo $k ?>">

<?php if($showFilter!='no') { ?>
        <a href="modal.php?p=filter-<?php echo $pag ?>-<?php echo $k ?>" title="Filtrare <?php echo $v ?>"></a>      
        <i class="fa fa-filter float-left text-<?php echo (isset($_SESSION['filter'][$k])?'white':'info'); ?>"          
           data-toggle="modal" data-target="#filterModal" onclick="goModal('filter-<?php echo $pag ?>-<?php echo $k ?>', 'Filtrare')"></i>        
<?php } ?>         
	<input name="order" type="hidden" value="<?php echo $k ?>" />                
<?php if($showOrder!='no') { if(!isset($_SESSION['order'][$k])) { ?>
    	<input name="ordertype" type="hidden" value="up" />
        <i class="fa fa-sort float-right text-info" onclick="$('#ord_<?php echo $k ?>').submit()" style="cursor:pointer"></i>
	<?php } else { ?>
    	<input id="ord_<?php echo $k ?>_type" name="ordertype" type="hidden" value="<?php echo ($_SESSION['order'][$k]=='up'?'dn':'up') ?>" />
        <i class="fa float-right text-white fa-sort-<?php echo $_SESSION['order'][$k]=="up"?"up":"down" ?>" onclick="$('#ord_<?php echo $k ?>').submit()" oncontextmenu="$('#ord_<?php echo $k ?>_type').val('');$('#ord_<?php echo $k ?>').submit(); return false;" style="cursor:pointer"></i>
	<?php }} ?>
</form>            </th>
<?php } ?>            
            <th>
                <input type="checkbox" id="ba" onchange="checkAll($(this).is(':checked'))">
                <label class="form-check-label text-light" for="ba"></label>                
            </th>
        </tr>
    </thead>
<form action="" method="post" id="multiForm" name="multiForm">
<tbody>
<input name="multi" type="hidden" value="yes" />        
<?php 
    if( count($rows) == 0 ) { ?>
        <tr>
            <td class="text-center" colspan="<?= 2+count($fields) ?>">
                <?= showMessage($MESSAGE, 'danger'); ?>
            </td>
        </tr>        
<?php                
    } else {
    foreach($rows as $r ) { ?>
        <tr>
            <td class="text-center">
<div class="btn-group dropright">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
  <div class="dropdown-menu">
<?php
    foreach($specials as $sp) 
        if(in_array($sp,$rcr['details_v'])) {
            $spd=$sp;if(isset($stitles[$sp])) $spd=$stitles[$sp];
?>
    <a class="dropdown-item" href="./toper-<?= $param[1] ?>-<?= $sp ?>-id-<?= $r[$id] ?>.htm"><i class="fa fa-<?= (isset($fontawesome[$sp])?$fontawesome[$sp]:$sp) ?>"></i> <?php echo ucfirst($spd) ?></a>
<?php } ?>
<?php if($rcr['modify_right']=='Y') {?>
    <a class="dropdown-item" href="./toper-<?php echo $param[1] ?>-edit-id-<?php echo $r[$id] ?>.htm"><i class="fa fa-pencil-alt"></i> Editeaza</a>
<?php } ?>
<?php if($rcr['delete_right']=='Y') {?>
    <a class="dropdown-item" href="./toper-<?php echo $param[1] ?>-drop-id-<?php echo $r[$id] ?>.htm"><i class="fa fa-times"></i> Sterge</a>
<?php } ?>
  </div>
</div>
            </td>
<?php foreach($fields as $k=>$v) { ?>
            <td<?php if($rcr['modify_right']=='Y') {?> class="cell" alt="<?php echo $k.'-'.$r[$id] ?>" title="<?=is_array($v)?$v['name']:$v ?>"<?php }?>>
<?php
    if(file_exists("settings/$pag/{$k}_show.php")) 
    {
        include("settings/$pag/{$k}_show.php"); 
    } else {
        fieldFormat($k, $v, $r[$k]);
    }
?></td>
<?php } ?>                
            <td class="text-center">
                <input type="checkbox" class="chboxoper" id="b<?= $r[$id] ?>" name="ids[]" value="<?= $r[$id] ?>">
                <label class="form-check-label" for="b<?= $r[$id] ?>"></label>                
            </td>
        </tr>
<?php }} ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="<?php echo count($fields)+($rcr['delete_right']=='Y'?1:0) ?>" style="text-align:right">
<?php if(is_array($multiOper)) foreach($multiOper as $k=>$v) {?>
<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#filterModal" 
        onclick="postModal('multi-<?= $param[1] ?>-<?php echo $k ?>-<?= $id ?>','<?php echo $v ?>', $('#multiForm').serialize() )"><?php echo $v ?></button>
    <?php } ?>
<?php if($rcr['delete_right']=='Y') {?>
<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#filterModal" onclick="postModal('multi-<?= $param[1] ?>-delete-<?= $id ?>','Sterge', $('#multiForm').serialize() )">STERGE</button>
<?php }; if(($rcr['delete_right']=='Y')||(is_array($multiOper))) {?>
<i class="fas fa-reply fa-rotate-90"></i>
<?php } ?>
    </td>
  </tr>                
</tbody>
</form>
</table>
</div>    

<?php if(!isset($dontshowpages)) { ?>

<ul class="pagination justify-content-center">
    <li class="page-item">
        <a class="page-link" href="./tabel-<?= $param[1]."-0".(isset($param[3])?"-".implode("-",array_slice($param,3)):'') ?>.htm">
        <i class="fas fa-angle-double-left pb-1"></i>
        </a>
    </li>
   
    <li class="page-item">
        <a class="page-link" href="./tabel-<?= $param[1].($st==0?'-0':'-'.($st-1)).(isset($param[3])?"-".implode("-",array_slice($param,3)):'') ?>.htm">
            <i class="fas fa-angle-left pb-1"></i>
        </a>
    </li>
    <li class="page-item">
        <span class="page-link">&nbsp;</span>
    </li>
<?php
    for($i=$st-3;$i<=$st+3;$i++)
        if(($i >= 0) && ($i <= $np)) {
?>
    <li class="page-item">
        <a class="page-link" href="./tabel-<?= $param[1].'-'.$i.(isset($param[3])?"-".implode("-",array_slice($param,3)):'') ?>.htm">
            <?= $i+1 ?>
        </a>
    </li>
<?php } ?>
    <li class="page-item">
        <span class="page-link">&nbsp;</span>
    </li>    
    <li class="page-item">
        <a class="page-link" href="./tabel-<?= $param[1].($st==$np?'-'.$np:'-'.($st+1)).(isset($param[3])?"-".implode("-",array_slice($param,3)):'') ?>.htm">
            <i class="fas fa-angle-right pb-1"></i>
        </a>
    </li>
 
    <li class="page-item">
        <a class="page-link" href="./tabel-<?= $param[1].'-'.$np.(isset($param[3])?"-".implode("-",array_slice($param,3)):'') ?>.htm">
        <i class="fas fa-angle-double-right pb-1"></i>
        </a>
    </li>  
</ul>
<?php } ?>


<?php /*
<div role="alert" class="alert alert-<?php echo $theme ?>"><h3>
<?php if($impex) { ?>
<div class="dropdown">
<?php } ?>
<?php echo (isset($overridetitle)?$overridetitle:$title) ?>
<?php if(count($impex)!=0) { ?>
<button id="dimpex" type="button" class="btn btn-<?php echo $theme ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right"><i class="fa fa-big fa-hdd-o"></i></button>
  <ul class="dropdown-menu" aria-labelledby="dimpex" style="left:auto; right:0">
<?php foreach($impex as $k=>$v) { ?>
    <li><a data-toggle="modal" data-target="#myImpExp" style="width:100%" onclick="goImpExp('<?php echo $k ?>')"><i class="fa fa-<?php echo $v ?>" aria-hidden="true"></i> <?php echo $k ?></a></li>
<?php }?>    
  </ul>
</div>
<?php } ?>
</h3></div>

<?php if($impex) { ?>
<div class="modal fade" id="myImpExp" tabindex="-1" role="dialog" aria-labelledby="myImpExpLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myImpExpLabel">-</h4>
      </div>
      <div class="modal-body" id="myImpExpBody"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
function goImpExp(x) {
	$('#myImpExpLabel').html(x);
	$('#myImpExpBody').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>');
	$.ajax({
	  url: "import/ajax.php?t=<?php echo $param[1] ?>&p="+x,
	}).done(function(msg) {
	  $('#myImpExpBody').html(msg);
<?php if(file_exists("custom/$param[1].js")) include("custom/$param[1].js"); ?>
	});
}
</script>
<?php 
	if(isset($_POST['col'])) {
		include("import/".$_POST['type'].".php");
		$n=0;
		foreach($rows as $r) {
		
			foreach($_POST['col'] as $k=>$v) if($v!=''){
				$a1[$k]=$v;
				$a2[$k]=$r[$k];
				if($v<>$id) $u[$k]="`$v`='".$r[$k]."'";
			}
			$sql="INSERT INTO $tabel (".implode(',', $a1).") VALUES ('".implode("', '", $a2)."') ON DUPLICATE KEY UPDATE ".implode(',', $u);
			mysql_query($sql) or die('<div role="alert" class="alert alert-danger">'.mysql_error()."<hr />$sql</div>");
			$n+=mysql_affected_rows();
		} 
	if($n>=0) { ?>
<div class="hidden-xs col-sm-1 col-md-2 col-lg-3"></div>    
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">   
    <div role="alert" class="alert alert-success">Import reusit ! <?php echo $n ?> linii afectate</div>
    <a href="./?p=tabel-<?php echo $param[1] ?>" class="btn btn-<?php echo $theme ?>" style="float:right">CONTINUA <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
</div>     
	<?php die();	}}
} ?>

<input name="item" id="itemdata" type="text" value="0" style="display:none" />
<?php 	if(file_exists("settings/$pag/top.php")) include("settings/$pag/top.php"); ?>
<script type="text/javascript">
function gomodal(l,t) {
	$('#filterModalLabel').html(t);
	$('#filterModal .modal-body').html('<h1 style="text-align:center"><i class="fa fa-spinner fa-pulse" style="font-size:108px"></i></h1>');
	$.ajax({
	  url: "ajaxmodal.php?p="+l,
	}).done(function(msg) {
	  $('#filterModal .modal-body').html(msg);
	});
}
</script>
<table border="0" cellspacing="1" cellpadding="3" align="center" class="table table-striped table-bordered">
  <tr class="t0">
    <td width="16">
<?php if(($filtersExists!=0)&&($showFilter!='no')) { ?>
<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" name="clearfilters"><input type="hidden" name="fv" value="999" /></form>
<i class="fa fa-filter" style="color:#900; cursor:pointer" onclick="document.clearfilters.submit()"></i>
<?php } else { ?>
<i class="fa fa-filter"></i>
<?php } ?>
	</td>
<?php foreach($fields as $k=>$v) {?>
    <td<?php if(isset($tabelw[$k])) echo ' width="'.$tabelw[$k].'"'?>><form action="" method="post" name="ord_<?php echo $k ?>">
<?php if($showFilter!='no') { ?>
        <a href="modal.php?p=filter-<?php echo $pag ?>-<?php echo $k ?>" title="Filtrare <?php echo $v ?>"></a>      
        <i class="fa fa-filter filter<?php echo (isset($_SESSION['filter'][$k])?'on':'off'); ?>" data-toggle="modal" data-target="#filterModal" onclick="gomodal('filter-<?php echo $pag ?>-<?php echo $k ?>', 'Filtrare')"></i>        
<?php } ?><?php echo $v ?>
	<input name="order" type="hidden" value="<?php echo $k ?>" />
<?php if($showOrder!='no') { if(!isset($_SESSION['order'][$k])) { ?>
    	<input name="ordertype" type="hidden" value="up" />
        <i class="fa fa-sort" onclick="document.ord_<?php echo $k ?>.submit()" style="cursor:pointer"></i>
	<?php } else { ?>
    	<input name="ordertype" type="hidden" value="<?php echo ($_SESSION['order'][$k]=='up'?'dn':'up') ?>" />
        <i class="fa fa-sort-amount-<?php echo $_SESSION['order'][$k]=="up"?"asc":"desc" ?>" onclick="document.ord_<?php echo $k ?>.submit()" style="cursor:pointer"></i>
	<?php }} ?></form></td>
<?php } ?>
    <td width="16"><?php if($rcr['adaugare']=='Y') {?><a href="./?p=tadd-<?php echo $param[1] ?>" class="btn btn-sm btn-<?php echo $theme ?>"><i class="fa fa-plus"></i></a><?php } ?></td>
  </tr>
<?php if($showInlineFilter=='yes') { ?>  
  <tr class="t0">
    <td>&nbsp;</td>
<?php foreach($fields as $k=>$v) { 
    if((count($InlineFilterFields)==0)||(in_array($k,$InlineFilterFields))) {?>
    <td>
        <form action="" method="post" name="iflt_<?php echo $k ?>">
            <input name="fld" type="hidden" value="<?= $k ?>">
            <input type="text" name="<?= $k ?>" value="<?= $_SESSION['filter'][$k] ?>" class="form-control" onblur="document.iflt_<?php echo $k ?>.submit()">
            <input type="hidden" name="fv" value="1">
        </form>
    </td>        
<?php } else { ?>  
    <td>&nbsp;</td>        
<?php }} ?>  
  </tr>
<?php } ?>  
<form action="" method="post">
<input name="multi" type="hidden" value="yes" />
<?php 
if(is_resource($re)) {
while($r=mysql_fetch_array($re)) { $nr++; 
$cl=($nr%2+1);
if(file_exists("settings/{$pag}/line.php")) include("settings/{$pag}/line.php");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
  <tr class="t<?php echo $cl ?>">
    <td width="16">
<div class="dropdown">
  <button class="btn btn-sm btn-<?php echo $theme ?> dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-right"></i></button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
<?php foreach($specials as $sp) if(in_array($sp,$rcr['detalii_v'])) {
$spd=$sp;if(isset($stitles[$sp])) $spd=$stitles[$sp];
?>
<li><a href="./?p=toper-<?php echo $param[1] ?>-<?php echo $sp ?>&id=<?php echo $r[$id] ?>"><i class="fa fa-<?php echo (isset($fontawesome[$sp])?$fontawesome[$sp]:$sp) ?>"></i> <?php echo ucfirst($spd) ?></a></li>
<?php } ?>
<?php if($rcr['modificare']=='Y') {?>
<li><a href="./?p=tedit-<?php echo $param[1] ?>&id=<?php echo $r[$id] ?>"><i class="fa fa-pencil"></i> Editeaza</a></li>
<?php } ?>
<?php if($rcr['stergere']=='Y') {?>
<li><a href="./?p=tdrop-<?php echo $param[1] ?>&id=<?php echo $r[$id] ?>"><i class="fa fa-times"></i> Sterge</a></li>
<?php } ?>
  </ul>
</div>
    </td>
<?php foreach($fields as $k=>$v) {?>
    <td<?php if($rcr['modificare']=='Y') {?> class="cell" alt="<?php echo $k.'-'.$r[$id] ?>" title="<?php echo $v ?>"<?php }?>>
<?php if(file_exists("settings/$pag/{$k}_show.php")) include("settings/$pag/{$k}_show.php"); else echo $r[$k] ?>	</td>
<?php } ?>
    <td><?php if(($rcr['stergere']=='Y')||(is_array($operations))) {?>
    <input name="d[<?php echo $r['id'] ?>]" id="d<?php echo $r['id'] ?>" type="checkbox" value="<?php echo $r['id'] ?>"<?php if(isset($_POST['d'][$r['id']])) echo " checked" ?> class="chboxoper" />
    <label for="d<?php echo $r['id'] ?>"></label>
	<?php } ?></td>
  </tr>
<?php }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>




  <tr class="t0">
    <td>&nbsp;</td>
    <td colspan="<?php echo count($fields)+($rcr['stergere']=='Y'?1:0) ?>" style="text-align:right">
<?php if($rcr['stergere']=='Y') {?>
    <input name="oper-delete" type="submit" value="STERGE" class="btn btn-<?php echo $theme ?>"  />
<?php } if(is_array($operations)) foreach($operations as $k=>$v) {?><input name="oper-<?php echo $k ?>" type="submit" value="<?php echo $v ?>" class="btn btn-<?php echo $theme ?>" /><?php } ?>
<?php if(($rcr['stergere']=='Y')||(is_array($operations))) {?>___<i class="fa fa-arrow-up"></i>&nbsp;&nbsp;&nbsp;<br />
<input name="chall" id="chall" type="checkbox" value="1" onchange="checkAll($(this).is(':checked'))" /><label for="chall"></label>&nbsp;&nbsp;
<?php } ?>
    </td>
  </tr>
<?php } else { ?>
  <tr class="t<?php echo ($nr%2+1) ?>" onmouseover="tdover(this, 0)" onmouseout="tdout(this, <?php echo ($nr%2+1) ?>)">
    <td colspan="<?php echo count($fields)+2 ?>">Nu exista inregistrari</td>
  </tr><?php } ?>
</form>
</table>
<div class="row" style="margin:0">&nbsp;</div>
*/ ?>
<?php if(file_exists("settings/$pag/bottom.php")) include("settings/$pag/bottom.php"); ?>

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="filterModalTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>

<div id="contextMenu" class="card clearfix" style="display:none">
    <div class="card-header bg-secondary text-white">
        <span class="panel-info"></span>
        <i class="fa fa-times float-right" style="cursor:pointer"></i>
    </div>
    <div class="card-body">
        <div class="row panel-data"></div>
        <div class="row panel-submit" style="margin-top:10px">
            <div class="col">&nbsp;</div>
            <div class="col"><button type="button" class="btn btn-primary spc" onclick="salveaza()" style="width: 100%">Ok</button></div>
            <div class="col"><button type="button" class="btn btn-primary spc" onclick="$('#contextMenu').hide();" style="width: 100%">Cancel</button></div>		        
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {

  $("body").on("contextmenu", ".cell", function(e) { 
    $("#contextMenu .panel-info").html('Editare '+$(this).attr("title"));
    $("#contextMenu .panel-data").html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');
    $("#contextMenu .panel-submit").slideUp('fast');
	
	w=$(window).width();
	x=e.pageX;
	
	if(x*2>w) x=x-w*3/10;
	
    $("#contextMenu").css({
      display: "block",
      left: x,
      top: e.pageY,
	  width: '30%'
    });
	$.ajax({
	  url: "ajax/modal.php?p=medit-<?php echo $pag ?>-"+$(this).attr("alt")
	}).done(function(msg) {
      $("#contextMenu .panel-submit").slideDown();
	  $("#contextMenu .panel-data").html(msg);
	});	
	
    return false;
  });

  $("#contextMenu").on("click", "i", function() {
     $("#contextMenu").hide();
  });

});

function salveaza() {
    sid=$('#ajaxid').val();
    sfld=$('#ajaxfield').val();
    $.post("ajax/modal.php?p=mdoedit-<?php echo $pag ?>", { id: sid, field: sfld , item: $('#ajaxitem').val() }, function( msg ) {
            $('.cell[alt="'+sfld+'-'+sid+'"]').html(msg);
            $('#contextMenu').hide();
    });
}

function checkAll(x) {
	$(".chboxoper").prop("checked", x==1);
}

function goModal(l,t,p) {
	$('#filterModalTitle').html(t);
	$('#filterModal .modal-body').html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');
	$.ajax({
	  url: "ajax/modal.php?p="+l,
	}).done(function(msg) {
	  $('#filterModal .modal-body').html(msg);
	});
}

function postModal(l,t,p) {
	$('#filterModalTitle').html(t);
	$('#filterModal .modal-body').html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');

        $.post( "ajax/modal.php?p="+l, p )
        .done(function(msg) {
	  $('#filterModal .modal-body').html(msg);
	});
}

</script>