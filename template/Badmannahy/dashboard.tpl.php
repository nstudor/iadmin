<?php 
    foreach($panelRows as $r) {
?>
<div class="row dashboard">
<?php 
    foreach($r['panels'] as $r2) { $panelData=$r2['data'];
?>
<div class="col col-xs-12 col-sm-<?php echo $r2['marimesm'] ?> col-lg-<?php echo $r2['marimelg'] ?>">
<?php if($r2['vizibil']=='Y') { 
    if(!$r2['no_box']) {?>
<div class="card">
    <div class="card-header bg-maroon text-light">
        <b><?php echo $r2['denumire'] ?></b>
        <i class="float-right fa fa-chevron-<?php echo ($r2['deschis']=='N'?"down":"up") ?>"></i>
    </div>
    <div class="card-body"<?php if($r2['deschis']=='N') echo " style='display:none'"?>>
        <?php include("dashboard-$r2[fisier].tpl.php")?>
    </div>
</div>    
    <?php } else { include("dashboard-$r2[fisier].tpl.php"); }} else echo "&nbsp;" ?>
</div>
<?php } ?>
</div>
<?php } ?>
<script type="text/javascript">
$('.dashboard i').click(function() {
    x=$(this).parent().parent();
    self=$(this);
    it=x.parent().find('.card-body').is(':visible');
    x.parent().find('.card-body').slideToggle('slow');
    if(it) {
        self.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        d='N';
    } else {
        self.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        d='Y';
    }
    // TODO: create ajaxmodal.php?p=mdoedit-dashboard
    $.post("ajaxmodal.php?p=mdoedit-dashboard", { id: x.attr('rel'), field: 'deschis', item: d }, function() { });
});
</script>
