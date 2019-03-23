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
        fieldFormat($k, $v, $r[$k],'','',$r[$id], $param[1]);
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
    <li class="page-item<?= $i==$st?' active':'' ?>">
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

    $("#contextMenu").css({
      display: "block",
      left: e.clientX,
      top: e.clientY,
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

function goModal(l, t, s='') {
	$('#filterModalTitle').html(t);

        $('#filterModal .modal-dialog').removeClass('modal-lg').removeClass('modal-sm');
        if(s!='') $('#filterModal .modal-dialog').addClass('modal-'+s);
            
	$('#filterModal .modal-body').html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');
	$.ajax({
	  url: "ajax/modal.php?p="+l,
	}).done(function(msg) {
	  $('#filterModal .modal-body').html(msg);
	});
}

function postModal(l,t,p, s='') {
	$('#filterModalTitle').html(t);
	$('#filterModal .modal-body').html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');

        $('#filterModal .modal-dialog').removeClass('modal-lg').removeClass('modal-sm');
        if(s!='') $('#filterModal .modal-dialog').addClass('modal-'+s);

        $.post( "ajax/modal.php?p="+l, p )
        .done(function(msg) {
	  $('#filterModal .modal-body').html(msg);
	});
}

</script>