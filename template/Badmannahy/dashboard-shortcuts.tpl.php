<?php
    $shortcuts=db_select('*', 'login_shortcuts', "(id_user=$ruser[id] OR id_role=$ruser[role]) AND public='Y'", 'ordine');
    foreach($shortcuts as $r) {
?>
<div class="col-xs-4 col-sm-3 col-lg-2 pad05"><div class="panel" style="background-color:<?= $r['backcolor'] ?>; border-color:<?= $r['bordercolor'] ?>;">
	<div class="panel-body pad5"><div class="embed-responsive embed-responsive-4by3">
                <a href="<?php echo $r['link'] ?>"<?php if($r['newtab']=='Y') echo ' target="_blank"' ?> style="color:<?= $r['textcolor'] ?>;"><br><i class="fa fa-<?php echo $r['fontawesome'] ?>" aria-hidden="true"></i><br /><?php echo $r['denumire'] ?></a>
	</div></div>
</div></div>
<?php } ?>